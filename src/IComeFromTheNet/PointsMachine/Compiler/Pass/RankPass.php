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
 * 1. Rank the scores inside a group by Desc and Asc order
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
           
            # clone the corss join table into rank table
           
            $sSql  = "INSERT INTO $sRankTableName ";
            $sSql .= ' (score_slot_id,rule_slot_id) ';
            $sSql .= ' SELECT score_slot_id, rule_slot_id';
            $sSql .="  FROM $sJoinTmpTableName ";
        
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
            
            # Rank the scores by Low to High
            
            
            
            
            
            # Rank the scores High to Low
            
            
            
            
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
            
        }
        
        
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */