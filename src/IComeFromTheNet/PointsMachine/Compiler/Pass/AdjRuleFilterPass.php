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
 * This process the scores tmp table 
 * 
 * CURRENT is the processing date.
 * 
 * 1. Will match a score with its possible current groups.
 * 2. Will match a score to their current episodes and remove if none found.
 * 3. Match system to their current episode and remove if none found.
 * 4. Match system zones to their current episode.
 * 5. Match event types to their current episode and remove if none found.
 * 6. Insert a matched score base value.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class ScoreFilterPass extends AbstractPass 
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
    
    
    protected function matchSystemsEpisodes(DateTime $oProcessingDate)
    {
        
        $oDatabase = $this->getDatabaseAdaper();
        $sRuleTmpTable = $this->getRuleTmpTableName();
        
        $sSystemTable  = $this->getGatewayCollection()
                            ->getGateway('pt_system')
                            ->getMetaData()
                            ->getName();                    
        
                            
        # find Adjustment Rules episodes
        # where using closed-open date pairs
        $sSql =  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET  k.system_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sSystemTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.system_id = k.system_id ';
        $sSql .= ')';
        
        
        $oDatabase->executeUpdate($sSql);
                                
        
       
    }
    
   
    
    
    
    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
        
          
            
        }
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */