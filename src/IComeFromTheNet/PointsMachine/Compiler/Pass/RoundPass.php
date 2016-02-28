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
 * Round the scores but first copy the cumulaitve value for each score into the 
 * scores tmp table.
 * 
 * CURRENT is the processing date.
 *  
 *  Have three rounding methods
 *  1. Normal 
 *  2. Ceil
 *  3. Floor
 * 
 * Rounding is optional if none set copy the raw value into rounded column.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class RoundPass extends AbstractPass 
{
  
    const PASS_PRIORITY = 90;


    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            
            $sRuleTableName     = $this->getRuleTableName();
            $sScoreTmpTableName = $this->getScoreTmpTableName();
            $sCommonTableName   = $this->getCommonTmpTableName();
            $sChainTableName    = $this->getChainTableName();
            $sAggTmpTableName   = $this->getAggValueTmpTableName();
            
            # copy last agg value for each score into scores table
        
            $sSql  =" UPDATE $sScoreTmpTableName sc ";
            $sSql .= " SET sc.score_cal_raw = ( ";
                 $sSql .=" SELECT sum(agg.cumval) ";
                 $sSql .=" FROM $sAggTmpTableName agg  ";
                 $sSql .=" WHERE sc.slot_id = agg.score_slot_id ";
            $sSql .= ");";
            
            $this->getDatabaseAdapter()->executeUpdate($sSql);
            
            # if no rules for the score then use the score base
            
            $sSql  =" UPDATE $sScoreTmpTableName sc ";
            $sSql .=" SET sc.score_cal_raw = sc.score_base";
            $sSql .=" WHERE sc.score_cal_raw IS NULL; ";
        
            $this->getDatabaseAdapter()->executeUpdate($sSql);
            
            
            
            # apply rounding rules defined in the rule chain
            $sSql  =" UPDATE $sScoreTmpTableName sc ";
            $sSql .=" SET sc.score_cal_rounded = ( ";
                        $sSql .=" CASE (SELECT ct.rounding_option
                                        FROM $sChainTableName ct 
                                        JOIN $sCommonTableName c ON ct.episode_id = c.rule_chain_ep  
                                        LIMIT 1) ";
                        $sSql .=" WHEN " .self::ROUND_NORMAL .' THEN ROUND(sc.score_cal_raw) ';
                        $sSql .=" WHEN " .self::ROUND_FLOOR  .' THEN FLOOR(sc.score_cal_raw) ';
                        $sSql .=" WHEN " .self::ROUND_CEIL   .' THEN CEIL(sc.score_cal_raw) ';
                        $sSql .=" ELSE sc.score_cal_raw ";
                        $sSql .=" END ";
            $sSql .=" ); ";
            
            $this->getDatabaseAdapter()->executeUpdate($sSql);
            
             
            $oResult->addResult(__CLASS__,'Executed Sucessfuly');
        
        }
        catch(DBALException $e) {
            $oResult->addError(__CLASS__,$e->getMessage());
          
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */