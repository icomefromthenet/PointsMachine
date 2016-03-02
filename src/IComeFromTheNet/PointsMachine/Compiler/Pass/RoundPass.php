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
 * Round the cumulative values of all scores in the round.
 * 
 * Expect the capping to be applied first.
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
  
    const PASS_PRIORITY = 200;
    

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
            $sTranEventTableName = $this->getTransactionEventTableName();
            
            
            # fetch the event id from the common table
            $sSql  = "SELECT `c`.`event_id` as event_id  FROM $sCommonTableName c";
            
            $iEventId = $this->getDatabaseAdapter()->fetchColumn($sSql,array(),0);
            
            if(true === empty($iEventId)) {
                throw new PointsMachineException('Unable to load event id from the common result table');
            }
            
            # apply rounding rules defined in the rule chain
            $sSql  =" UPDATE $sTranEventTableName sc ";
            $sSql .=" SET `sc`.`calrunvalue_round` = ( ";
                        $sSql .=" CASE (SELECT `ct`.`rounding_option`
                                        FROM $sChainTableName ct 
                                        JOIN $sCommonTableName c ON `ct`.`episode_id` = `c`.`rule_chain_ep`  
                                        LIMIT 1) ";
                        $sSql .=" WHEN " .self::ROUND_NORMAL .' THEN ROUND(`sc`.`calrunvalue`) ';
                        $sSql .=" WHEN " .self::ROUND_FLOOR  .' THEN FLOOR(`sc`.`calrunvalue`) ';
                        $sSql .=" WHEN " .self::ROUND_CEIL   .' THEN  CEIL(`sc`.`calrunvalue`) ';
                        $sSql .=" ELSE `sc`.`calrunvalue` ";
                        $sSql .=" END ";
            $sSql .=" ) WHERE `sc`.`event_id` = :iEventId;";
            
            $this->getDatabaseAdapter()->executeUpdate($sSql,array(':iEventId'=>$iEventId));
            
             
            $oResult->addResult(__CLASS__,'Executed Sucessfuly');
        
        }
        catch(DBALException $e) {
            $oResult->addError(__CLASS__,$e->getMessage());
          
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */