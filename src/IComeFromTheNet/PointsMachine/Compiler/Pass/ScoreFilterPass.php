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
     * Fetch the table name for this scores tmp table
     *  
     * @return string the tmp table name
     * @access protected
     */ 
    protected function getScoreTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_score')
                            ->getMetaData()
                            ->getName();
        
    }
    
    
    protected function matchSystemsEpisodes(DateTime $oProcessingDate)
    {
        
        $oDatabase = $this->getDatabaseAdaper();
        $sScoreTmpTable = $this->getScoreTmpTableName();
        
        $sSystemTable  = $this->getGatewayCollection()
                            ->getGateway('pt_system')
                            ->getMetaData()
                            ->getName();                    
        
                            
        # find system entities episodes
        # where using closed-open date pairs
        $sSql =  'UPDATE '.$sScoreTmpTable.' k ';
        $sSql .= 'SET  k.system_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sSystemTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.system_id = k.system_id ';
        $sSql .= ')';
        
        
        $oDatabase->executeUpdate($sSql);
                                
        
       
    }
    
    
    protected function matchScoreEpisodes(DateTime $oProcessingDate)
    {
        $oDatabase = $this->getDatabaseAdaper();
        $sScoreTmpTable = $this->getScoreTmpTableName();
        $sScoreTable  = $this->getGatewayCollection()
                            ->getGateway('pt_score')
                            ->getMetaData()
                            ->getName();         
        
        # find score episodes
        # where using closed-open date pairs
        $sSql =  'UPDATE '.$sScoreTmpTable.' k ';
        $sSql .= 'SET  k.score_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sScoreTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.score_id = k.score_id ';
        $sSql .= ')'; 
        
        $oDatabase->executeUpdate($sSql);
        
        # set the score base values
        $sSql =  'UPDATE '.$sScoreTmpTable.' k ';
         $sSql .= 'SET  k.score_base = (';
            $sSql .= 'SELECT j.score_value ';
            $sSql .= 'FROM  '.$sScoreTable.' j ';
            $sSql .= 'WHERE  j.episode_id = k.score_ep AND j.score_id = k.score_id ';
        $sSql .= ')'; 
        $sSql .= ',k.score_group_id = (';
            $sSql .= 'SELECT j.score_group_id ';
            $sSql .= 'FROM  '.$sScoreTable.' j ';
            $sSql .= 'WHERE  j.episode_id = k.score_ep AND j.score_id = k.score_id ';
        $sSql .= ')';  
       
        $oDatabase->executeUpdate($sSql);
    }
     
 
    
    protected function matchScoreGroupsEpisodes(DateTime $oProcessingDate)
    {
        $oDatabase = $this->getDatabaseAdaper();
        $sScoreTmpTable = $this->getScoreTmpTableName();
        $sGroupTable  = $this->getGatewayCollection()
                            ->getGateway('pt_score_group')
                            ->getMetaData()
                            ->getName();  
        
        # find score group episode
        # where using closed-open date pairs
        $sSql =  'UPDATE '.$sScoreTmpTable.' k ';
        $sSql .= 'SET  k.score_group_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sGroupTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.score_group_id = k.score_group_id ';
        $sSql .= ')'; 
        
        $oDatabase->executeUpdate($sSql);
    }
    
    protected function matchSystemZonesEpisodes()
    {
        $oDatabase = $this->getDatabaseAdaper();
        $sScoreTmpTable = $this->getScoreTmpTableName();
        
        $sZoneTable  = $this->getGatewayCollection()
                            ->getGateway('pt_system_zone')
                            ->getMetaData()
                            ->getName();  
        
        # find score group episode
        # where using closed-open date pairs
        $sSql =  'UPDATE '.$sScoreTmpTable.' ';
        $sSql .= 'SET  system_zone_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sZoneTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= processing_date AND j.enabled_to > processing_date ';
            $sSql .= 'AND j.zone_id = system_zone_id ';
        $sSql .= ')';
    
        $oDatabase->executeUpdate($sSql);
    }
    
     protected function matchEventTypesEpisodes()
    {
        $oDatabase = $this->getDatabaseAdaper();
        $sScoreTmpTable = $this->getScoreTmpTableName();
        
        $sEtypeTable  = $this->getGatewayCollection()
                            ->getGateway('pt_event_type')
                            ->getMetaData()
                            ->getName();  
        
        # find score group episode
        # where using closed-open date pairs
        $sSql =  'UPDATE '.$sScoreTmpTable.' k ';
        $sSql .= 'SET  k.event_type_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sEtypeTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.event_type_id = k.event_type_id ';
        $sSql .= ')';
    
        $oDatabase->executeUpdate($sSql);
    }
    
    protected function removeExpiredEntities()
    {
        $oDatabase = $this->getDatabaseAdaper();
        $sScoreTmpTable = $this->getScoreTmpTableName();
    
        
        # remove systems that did not exist
        
        $sSql  = 'DELETE FROM '.$sScoreTmpTable. ' ';
        $sSql  .='WHERE system_ep IS NULL ';
        $sSql  .='OR event_type_ep IS NULL ';
        $sSql  .='OR score_ep IS NULL ';
        
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
        
            $this->matchSystemsEpisodes($oProcessingDate);
            
            $this->matchSystemZonesEpisodes($oProcessingDate);
            
            $this->matchEventTypesEpisodes($oProcessingDate);
            
            $this->matchScoreEpisodes($oProcessingDate);
            
            $this->matchScoreGroupsEpisodes($oProcessingDate);
            
            $this->removeExpiredEntities($oProcessingDate);
            
        }
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */