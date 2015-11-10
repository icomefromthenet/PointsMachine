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
    

    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            $sRankTmpTableName  = $this->getRankTmpTableName();
            $sRuleTmpTableName  = $this->getRuleTmpTableName();
            $sTranLogTableName  = $this->getTransactionLogTableName();
            $sRuleGroupTable    = $this->getRuleGroupTableName();  
            
            # Save the rank and rule values into this details tmp table
            $sSql .=" INSERT INTO $sDetailsTmpTable ";
            $sSql .= " (slot_id, rule_ep, rule_id, rule_group_ep, rule_group_id, rank, modifier, multiplier ) ";
            $sSql .= " SELECT null 
                        , rnk.rule_ep
                        , rnk.rule_id
                        , rnk.rule_group_ep
                        , rnk.rule_group_id
                        , ( 
                            CASE(rg.order_method)
                                WHEN 1 THEN rank_high
                                WHEN 0 THEN rank_low
                            END
                          ) 
                        , rt.override_modifier
                        , rt.override_multiplier ";
            $sSql .= " FROM $sRankTmpTableName rnk  ";
            $sSql .= " JOIN $sRuleTmpTableName rt ON rt.slot_id = rnk.rule_slot_id ";
            $sSql .= " JOIN $sRuleGroupTable rg ON r.episode_id = rt.rule_group_ep ";
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
        
        }
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */