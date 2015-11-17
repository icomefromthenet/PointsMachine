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
 * This process the normalize the score values
 * 
 * CURRENT is the processing date.
 * 
 * This will remove rules that exceed the max count setting
 * found on the group. Need the rank first so this must 
 * happen after thats been assigned. 
 * 
 * This will respect the order setting on the group (max or min)
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class LimitPass extends AbstractPass 
{
    

    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            $sRankTmpTableName   = $this->getRankTmpTableName();
            $sCJoinTmpTableName  = $this->getCJoinTmpTableName();
            $sRuleTmpTableName   = $this->getRuleTmpTableName();
            $sRuleTableName      = $this->getRuleTableName();
            $sRuleGroupTableName = $this->getRuleGroupTableName();
            $oCJoinTableMaker = $this->getTableMaker('pt_result_cjoin');
           
           
            # Remove rules that exceed the allowed max
            
            $sSql  = " DELETE rnk FROM $sRankTmpTableName  rnk";
            $sSql .= " JOIN $sRuleTmpTableName   rt ON rt.slot_id   = rnk.rule_slot_id ";        
            $sSql .= " JOIN $sRuleGroupTableName r  ON r.episode_id = rt.rule_group_ep ";        
            $sSql .= " WHERE (r.max_count IS NOT NULL AND r.order_method = 0 AND rnk.rank_low  > r.max_count ) ";
            $sSql .= " OR    (r.max_count IS NOT NULL AND r.order_method = 1 AND rnk.rank_high > r.max_count ); ".PHP_EOL;
    

            # update the join table with new row set
            $oCJoinTableMaker->truncateTable();
            
            $sSql .= " INSERT $sCJoinTmpTableName (score_slot_id, rule_slot_id) ";
            $sSql .= " SELECT score_slot_id, rule_slot_id FROM $sRankTmpTableName ;".PHP_EOL;        
        
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