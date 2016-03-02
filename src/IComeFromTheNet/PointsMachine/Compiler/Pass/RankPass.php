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
 * This build ranks for the rules. 
 * 
 * CURRENT is the processing date.
 *
 * 1. Rank the rules inside a group by Desc and Asc order
 * 2. Rank the chain by pulling seq number from the chain member
 * 
 * We use the combined value of normalize mods so we have
 * (modifer * multiplier) this fetch from the max column in
 * rules tmp table.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class RankPass extends AbstractPass 
{
    
    const PASS_PRIORITY = 60;
    
    
    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
        
           $sScoreTmpTableName  = $this->getScoreTmpTableName();
           $sRuleTmpTableName   = $this->getRuleTmpTableName();
           $sJoinTmpTableName   = $this->getCJoinTmpTableName();
           $sCommonTmpTableName = $this->getCommonTmpTableName();
           $sRankTableName      = $this->getRankTmpTableName();
           $sChainMemberTable   = $this->getChainMemberTableName();
           
            # clone the corss join table into rank table
           
            $sSql  = " INSERT INTO $sRankTableName ";
            $sSql .= ' (score_slot_id, rule_slot_id, rule_ep, rule_id, rule_group_ep, rule_group_id, max_value) ';
            $sSql .= ' SELECT j.score_slot_id, j.rule_slot_id, rt.rule_ep, rt.rule_id, rt.rule_group_ep, rt.rule_group_id, rt.max_value ';
            $sSql .="  FROM $sJoinTmpTableName j ";
            $sSql .="  JOIN $sRuleTmpTableName rt ON j.rule_slot_id = rt.slot_id;  ".PHP_EOL;
        
           $this->getDatabaseAdaper()->executeUpdate($sSql);
         
            
            # Rank the scores by High to LOW
            
            $sSql  = "UPDATE $sRankTableName x ";
            $sSql .= " SET rank_high = ( ";
                $sSql .= " SELECT count(r.slot_id) ";
                $sSql .=" FROM $sJoinTmpTableName j "; 
                $sSql .=" JOIN $sRuleTmpTableName r ON j.rule_slot_id = r.slot_id";
                $sSql .=" WHERE x.rule_group_id = r.rule_group_id AND x.score_slot_id  = j.score_slot_id ";
                $sSql .=" AND (r.max_value > x.max_value ";
                    $sSql .=" OR (r.max_value = x.max_value AND r.slot_id = x.rule_slot_id)) ";
                $sSql .=" ORDER BY r.max_value DESC, r.slot_id DESC ";
            $sSql .= " ); ".PHP_EOL;
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
         
            
            
            # Rank the scores Low To High
            
            $sSql  = "UPDATE $sRankTableName x ";
            $sSql .= " SET rank_low = ( ";
                       $sSql .= " SELECT count(r.slot_id) ";
                $sSql .=" FROM $sJoinTmpTableName j "; 
                $sSql .=" JOIN $sRuleTmpTableName r ON j.rule_slot_id = r.slot_id";
                $sSql .=" WHERE x.rule_group_id = r.rule_group_id AND x.score_slot_id  = j.score_slot_id ";
                $sSql .=" AND (r.max_value < x.max_value ";
                    $sSql .=" OR (r.max_value = x.max_value AND r.slot_id = x.rule_slot_id)) ";
                $sSql .=" ORDER BY r.max_value ASC, r.slot_id ASC ";
            $sSql .= " ); ".PHP_EOL;
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
            
            # fetch ranks for the rule groups.
            $sSql .= "UPDATE $sRankTableName x ";
            $sSql .= " SET rule_group_seq = ( ";
                       $sSql .= " SELECT c.order_seq ";
                $sSql .=" FROM $sJoinTmpTableName j "; 
                $sSql .=" JOIN $sRuleTmpTableName r ON j.rule_slot_id = r.slot_id";
                $sSql .=" JOIN $sChainMemberTable c ON c.episode_id = r.chain_member_ep";
                $sSql .=" WHERE x.rule_slot_id = j.rule_slot_id  AND x.score_slot_id  = j.score_slot_id ";
            $sSql .= " ); ".PHP_EOL;
            
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
            
            $oResult->addResult(__CLASS__,'Executed Sucessfuly');
            
        }
        
        
        catch(DBALException $e) {
            $oResult->addError(__CLASS__,$e->getMessage());
          
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */