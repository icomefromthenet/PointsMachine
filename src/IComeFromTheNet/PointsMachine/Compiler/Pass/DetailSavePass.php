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
 * This process save the rules to the transaction log table
 * 
 * CURRENT is the processing date.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class DetailSavePass extends AbstractPass 
{
    
     const PASS_PRIORITY = 150;

    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            $sRankTmpTableName = $this->getRankTmpTableName();
            $sTranRuleTableName = $this->getTransactionAdjRuleTableName();
            $sTranAdjGroupTableName = $this->getTransactionAdjGroupTableName();
            $sTranScoreTableName = $this->getTransactionScoreTableName();
            $sTranEventTableName = $this->getTransactionEventTableName();
            $sCommonTmpTableName = $this->getCommonTmpTableName();
            $sScoreTmpTableName  = $this->getScoreTmpTableName(); 
            $sRuleTmpTableName  = $this->getRuleTmpTableName();  
            $sAdjGroupTableName = $this->getRuleGroupTableName();
            $sAggTmpTableName   = $this->getAggValueTmpTableName();
            
            
            # Save the rules into rules transaction table
            # A (rule/score) combination can be repeated but values will be the same we only looking to store one instance of these values
      
            $sSql  =" INSERT INTO $sTranRuleTableName ";
            $sSql .=" (`event_id`, `score_ep`, `rule_ep`, `score_modifier`, `score_multiplier`, `order_seq`) ";
            $sSql .=" SELECT `c`.`event_id`
                        , `s`.`score_ep`
                        , `r`.`rule_ep`
                        , `ru`.`override_modifier`   as score_modifier
                        , `ru`.`override_multiplier` as score_multiplier
                        , IF(`ag`.`order_method` = 1, `r`.`rank_high`,`r`.`rank_low`) as order_seq";
            $sSql .=" FROM $sRankTmpTableName r ";
            $sSql .=" CROSS JOIN $sCommonTmpTableName c ";
            $sSql .=" JOIN $sScoreTmpTableName s ON `s`.`slot_id` = `r`.`score_slot_id` ";
            $sSql .=" JOIN $sRuleTmpTableName ru ON `ru`.`rule_ep` = `r`.`rule_ep` ";
            $sSql .= "JOIN $sAdjGroupTableName ag ON `ag`.`episode_id` = `ru`.`rule_group_ep` ";
            $sSql .= "GROUP BY `c`.`event_id`, `s`.`score_ep`, `r`.`rule_ep`, `ru`.`override_modifier`, `ru`.`override_multiplier`, `ag`.`order_method`, `r`.`rank_high`, `r`.`rank_low` ";
            
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
            # Save the group Agg into the group transaction table
            # if a same score is included in same run it will share same values for each group we only looking to store one instance of these values
            
            $sSql = "INSERT INTO $sTranAdjGroupTableName ";
            $sSql .=" (`event_id`, `score_ep`, `rule_group_ep`, `score_modifier`, `score_multiplier`, `order_seq`) ";
            $sSql .=" SELECT `c`.`event_id`
                        , `s`.`score_ep`
                        , `r`.`rule_group_ep`
                        , `r`.`modifier`   as score_modifier
                        , `r`.`multiplier` as score_multiplier
                        , `r`.`rank` as order_seq ";
            $sSql .=" FROM $sAggTmpTableName r ";
            $sSql .=" CROSS JOIN $sCommonTmpTableName c ";
            $sSql .=" JOIN $sScoreTmpTableName s ON `s`.`slot_id` = `r`.`score_slot_id` ";
            $sSql .=" GROUP BY `c`.`event_id`, `s`.`score_ep`, `r`.`rule_group_ep`, `r`.`modifier`, `r`.`multiplier`, `r`.`rank`";
              
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
            # Save the scores in the scores table
            # as scores may be repeated and will always have the same find values we only want to store the first instance with others incrementing a count
            $sSql  = "INSERT INTO $sTranScoreTableName ";
            $sSql .=" (`event_id`, `score_ep`, `score_group_ep`, `score_base`, `score_cal_raw`, `score_cal_capped`,`score_quantity`)";
            $sSql .=" (SELECT `c`.`event_id`, `s`.`score_ep`, `s`.`score_group_ep`, `s`.`score_base`, `s`.`score_cal_raw`, `s`.`score_cal_capped`, 1 ";
            $sSql .=" FROM  $sScoreTmpTableName s";
            $sSql .=" CROSS JOIN $sCommonTmpTableName c )";
            $sSql .=" ON DUPLICATE KEY UPDATE `score_quantity`=`score_quantity`+1 ";
                
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
            # save the common into the header table
            # this also include a total of all scores in the score tmp table
            $sSql  =" INSERT $sTranEventTableName ";
            $sSql .=" (`event_id`, `system_ep`, `zone_ep`, `event_type_ep`, `created_date`, `processing_date`, `occured_date`,`calrunvalue`) ";
            $sSql .=" SELECT `c`.`event_id`, `c`.`system_ep`, `c`.`system_zone_ep`, `c`.`event_type_ep`, NOW() , ";
            $sSql .="  `c`.`processing_date`, `c`.`processing_date`,(SELECT sum(ifnull(`score_cal_capped`,`score_cal_raw`)) FROM $sScoreTmpTableName) ";
            $sSql .=" FROM $sCommonTmpTableName c ";
        
            
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