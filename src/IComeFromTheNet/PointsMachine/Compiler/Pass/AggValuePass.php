<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Pass;

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use DBALGateway\Table\GatewayProxyCollection;
use Doctrine\DBAL\Types\Type;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Agg Rules and Scores.
 * 
 * CURRENT is the processing date.
 * 
 * This will calculate AGG for each Adjustment Group - Score combination.
 *
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggValuePass extends AbstractPass 
{
    

    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            $sRankTmpTableName  = $this->getRankTmpTableName();
            $sRuleTableName     = $this->getRuleTableName();
            $sScoreTmpTableName = $this->getScoreTmpTableName();
            $sRuleTmpTableName  = $this->getRuleTmpTableName();
            $sAggTmpTableName   = $this->getAggValueTmpTableName();
            $sChainMemberTableName  = $this->getChainMemberTableName();
            $sRuleGroupTableName  = $this->getRuleGroupTableName();
        
            # Insert basic data into the agg table
            $sSql = " INSERT INTO $sAggTmpTableName (score_slot_id, rule_group_ep, rule_group_id, rank, modifier, multiplier, cumval) ";
            $sSql .=" SELECT rnk.score_slot_id, r.rule_group_ep, rnk.rule_group_id, max(rnk.rule_group_seq), 0, 1, 0";
            $sSql .=" FROM $sRankTmpTableName rnk ";
            $sSql .=" JOIN $sRuleTmpTableName r ON r.slot_id = rnk.rule_slot_id ";
            $sSql .=" GROUP BY rnk.score_slot_id, rnk.rule_group_id, rnk.rule_group_ep;". PHP_EOL;
        
        
            # calculate the modifier for each group
            $sSql .= " UPDATE $sAggTmpTableName a";
            $sSql .= " SET modifier = ( ";
                    $sSql .= " SELECT IFNULL(sum(r.override_modifier),0) ";
                    $sSql .= " FROM  $sRankTmpTableName rnk ";
                    $sSql .= " JOIN  $sRuleTmpTableName r on rnk.rule_slot_id = r.slot_id ";
                    $sSql .= " WHERE a.rule_group_ep = rnk.rule_group_ep AND a.score_slot_id = rnk.score_slot_id ";
            $sSql .= ");". PHP_EOL;
            
            
            # calculate the multipliers for each group
            # this AGG cal will fail on values of values <= 0
            # round up after 8th decimal place as where using a hack in place of SQL PRODUCT 
            $sSql .= " UPDATE $sAggTmpTableName a";
            $sSql .= " SET multiplier = ( ";
                    $sSql .= " SELECT round(Exp(Sum(Log(r.override_multiplier))),8) ";
                    $sSql .= " FROM  $sRankTmpTableName rnk ";
                    $sSql .= " JOIN  $sRuleTmpTableName r on rnk.rule_slot_id = r.slot_id ";
                    $sSql .= " WHERE a.rule_group_ep = rnk.rule_group_ep AND a.score_slot_id = rnk.score_slot_id ";
            $sSql .= ");". PHP_EOL;
            
        
            ## Need to process the Min and Max settings for each Adjustment Group
        
            $sSql .= " UPDATE $sAggTmpTableName  agg";
            $sSql .= " JOIN $sRuleGroupTableName r  ON r.episode_id = agg.rule_group_ep ";
            $sSql .= " SET agg.modifier = (CASE  ";
                                    $sSql .= " WHEN (r.max_modifier IS NOT NULL) AND (agg.modifier > r.max_modifier) THEN r.max_modifier ";
                                    $sSql .= " WHEN (r.min_modifier IS NOT NULL) AND (agg.modifier < r.min_modifier) THEN r.min_modifier ";
                                    $sSql .= " ELSE agg.modifier ";
                                $sSql .= " END) ";
            $sSql .= ", agg.multiplier = (CASE  ";
                                    $sSql .= " WHEN (r.max_multiplier IS NOT NULL) AND (agg.multiplier > r.max_multiplier) THEN r.max_multiplier ";
                                    $sSql .= " WHEN (r.min_multiplier IS NOT NULL) AND (agg.multiplier < r.min_multiplier) THEN r.min_multiplier ";
                                    $sSql .= " ELSE agg.multiplier ";
                                $sSql .= " END);";
        
            
            $this->getDatabaseAdapter()->executeUpdate($sSql);
            
            
            
            # Calculate the Cumulative value with a variable for Cumulative Value
            # where doing slow update because we can't refer to same TMP table twice in a query
            $sSql  = " SELECT agg.score_slot_id, agg.rule_group_ep, agg.rule_group_id ,@running_total := @running_total + (r.score_base + max(agg.modifier)) * max(agg.multiplier) AS cumulative_sum ";
            $sSql .= " FROM  $sAggTmpTableName agg ";
            $sSql .= " JOIN  $sScoreTmpTableName r on agg.score_slot_id = r.slot_id ";
            $sSql .= " JOIN  (SELECT @running_total := 0) rt ";
            $sSql .= " GROUP BY agg.score_slot_id, agg.rule_group_ep, agg.rule_group_id ";
            $sSql .= " ORDER BY agg.rank; "; 

            $oStmt = $this->getDatabaseAdapter()->query($sSql);
            
            while ($aData = $oStmt->fetch()) {

          
                $sSql  = " UPDATE $sAggTmpTableName ";
                $sSql .= " SET cumval = :fCumVal ";
                $sSql .= " WHERE score_slot_id = :iScoreSlotId ";
                $sSql .= " AND   rule_group_ep = :iRuleGroupEp ";
                $sSql .= " AND   rule_group_id = :iRuleGroupId ";
                
                $this->getDatabaseAdapter()->executeUpdate($sSql ,array( 'iScoreSlotId' => $aData['score_slot_id']
                                                                  ,'iRuleGroupEp' => $aData['rule_group_ep']
                                                                  ,'iRuleGroupId' => $aData['rule_group_id']
                                                                  ,'fCumVal'      => $aData['cumulative_sum']
                                                           ));
                
            }
        
        }
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */