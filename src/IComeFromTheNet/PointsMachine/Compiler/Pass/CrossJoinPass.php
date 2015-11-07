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
 * This process the rules cjoin table 
 * 
 * CURRENT is the processing date.
 *
 *  This build a cross join of scores and rules.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class CrossJoinPass extends AbstractPass 
{
    
    /**
     * Fetch the table name for this rules tmp table
     *  
     * @return string the tmp table name
     * @access protected
     */ 
    protected function getRuleTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_rule')
                            ->getMetaData()
                            ->getName();
        
    }
    
    protected function getScoreTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_score')
                            ->getMetaData()
                            ->getName();
        
    }
    
    protected function getCJoinTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_cjoin')
                            ->getMetaData()
                            ->getName();
        
    }
    
   
    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
        
            $sRuleLimitsTableName = $this->getGatewayCollection()
                            ->getGateway('pt_rule_group_limits')
                            ->getMetaData()
                            ->getName();
           
           $sScoreTmpTableName = $this->getScoreTmpTableName();
           $sRuleTmpTableName   = $this->getRuleTmpTableName();
           $sJoinTmpTableName  = $this->getCJoinTmpTableName();
           $sCommonTmpTableName = $this->getCommonTmpTableName();
           
            $sSql  = 'INSERT INTO ' . $sJoinTmpTableName .' ';
            $sSql .= ' (score_slot_id,rule_slot_id) ';
            $sSql .= ' SELECT a.slot_id, b.slot_id';
            $sSql .="  FROM $sScoreTmpTableName a , $sRuleTmpTableName b, $sCommonTmpTableName k";
        
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
            # remove rule groups that dont apply current score group
            # check if rule group has a requirement of the current score group 
            # or voids the none means all and requirement.
        
            $sSql  = " DELETE a FROM $sJoinTmpTableName a ";
            $sSql .= " JOIN $sRuleTmpTableName r ON r.slot_id = a.rule_slot_id ";
            $sSql .= " JOIN $sScoreTmpTableName s ON s.slot_id = a.score_slot_id ";
            $sSql .= " WHERE NOT EXISTS (SELECT 1 FROM $sRuleLimitsTableName  j , $sCommonTmpTableName l ";
                            $sSql .= " WHERE  j.enabled_from <= l.processing_date ";
                            $sSql .= " AND j.enabled_to > l.processing_date ";
                            $sSql .= " AND r.rule_group_id = j.rule_group_id ";
                            $sSql .= " AND s.score_group_id = j.score_group_id) ";
            $sSql .= ' AND r.apply_all_score = 0 ';        
    
    
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
        }
        
        
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */