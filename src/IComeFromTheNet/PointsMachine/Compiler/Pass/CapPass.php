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
 * Applies the cap to each score. The Cap is optional 
 * 
 * CURRENT is the processing date.
 *  
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class CapPass extends AbstractPass 
{
  
    const PASS_PRIORITY = 100;

    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
      
       
        try {
            
            $sScoreTmpTableName = $this->getScoreTmpTableName();
            $sCommonTableName   = $this->getCommonTmpTableName();
            $sChainTableName    = $this->getChainTableName();

            # apply the cap rules defined in the rule chain
        
            $sSql  =" UPDATE $sScoreTmpTableName sc ";
            $sSql .=" JOIN (SELECT (SELECT ct.cap_value ";
                                                $sSql .=" FROM $sChainTableName ct ";
                                                $sSql .=" JOIN $sCommonTableName c ON ct.episode_id = c.rule_chain_ep  ";
                                                $sSql .=" LIMIT 1) as cap_value, @pt_total := 0) k "; 
            $sSql .=" SET sc.score_cal_capped = ( ";
                $sSql .=" CASE    ";
                        $sSql .=" WHEN k.cap_value IS NOT NULL AND k.cap_value  > 0 THEN  ";
                            $sSql .=" CASE @pt_total > k.cap_value";
                                $sSql .=" WHEN false THEN ";
                                    $sSql .=" CASE (@pt_total := @pt_total +sc.score_cal_rounded) > k.cap_value ";
                                        $sSql .=" WHEN TRUE THEN sc.score_cal_rounded - (@pt_total - k.cap_value)";
                                        $sSql .=" WHEN FALSE THEN sc.score_cal_rounded  ";
                                    $sSql .=" END ";
                                $sSql .=" WHEN true THEN 0";
                            $sSql .=" END ";
                        $sSql .=" WHEN k.cap_value IS NOT NULL AND k.cap_value  < 0  THEN ";
                            $sSql .=" CASE @pt_total < k.cap_value ";
                                $sSql .=" WHEN false THEN ";
                                    $sSql .=" CASE (@pt_total := @pt_total + sc.score_cal_rounded) < k.cap_value ";
                                        $sSql .=" WHEN TRUE THEN sc.score_cal_rounded - (( ABS(@pt_total) - ABS(k.cap_value) ) * -1)";
                                        $sSql .=" WHEN FALSE THEN sc.score_cal_rounded  ";
                                    $sSql .=" END ";
                                $sSql .=" WHEN true THEN 0";
                            $sSql .=" END ";
                    $sSql .=" ELSE sc.score_cal_rounded ";
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