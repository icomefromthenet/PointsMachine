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
 * 3. Insert a matched score base value.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class ScoreFilterPass extends AbstractPass 
{
    
    
    const PASS_PRIORITY = 20;
    
    
    
    protected function matchScoreEpisodes(DateTime $oProcessingDate)
    {
        $sSql = '';
        $sScoreTmpTable = $this->getScoreTmpTableName();
        $sCommonTable = $this->getCommonTmpTableName();
        $sScoreTable  = $this->getScoreTableName();
        
        
        # find score episodes
        # where using closed-open date pairs
        $sSql .=  'UPDATE '.$sScoreTmpTable.' k ';
        $sSql .= 'SET  k.score_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sScoreTable.' j , '.$sCommonTable. ' l ';
            $sSql .= 'WHERE  j.enabled_from <= l.processing_date AND j.enabled_to > l.processing_date ';
            $sSql .= 'AND j.score_id = k.score_id ';
        $sSql .= ');'.PHP_EOL; 
        
      
        
        # set the score base values
        $sSql .=  'UPDATE '.$sScoreTmpTable.' k ';
         $sSql .= 'SET  k.score_base = (';
            $sSql .= 'SELECT j.score_value ';
            $sSql .= 'FROM  '.$sScoreTable.' j ';
            $sSql .= 'WHERE  j.episode_id = k.score_ep AND j.score_id = k.score_id ';
        $sSql .= ')'; 
        $sSql .= ',k.score_group_id = (';
            $sSql .= 'SELECT j.score_group_id ';
            $sSql .= 'FROM  '.$sScoreTable.' j ';
            $sSql .= 'WHERE  j.episode_id = k.score_ep AND j.score_id = k.score_id ';
        $sSql .= ');'.PHP_EOL;  
       
        return $sSql;
    }
     
 
    
    protected function matchScoreGroupsEpisodes(DateTime $oProcessingDate)
    {
        $sSql = '';
        
        $sScoreTmpTable = $this->getScoreTmpTableName();
        $sCommonTable = $this->getCommonTmpTableName();
        $sGroupTable  = $this->getScoreGroupTableName();
        
        # find score group episode
        # where using closed-open date pairs
        $sSql .=  'UPDATE '.$sScoreTmpTable.' k ';
        $sSql .= 'SET  k.score_group_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sGroupTable.' j  , '.$sCommonTable. ' l ';
            $sSql .= 'WHERE  j.enabled_from <= l.processing_date AND j.enabled_to > l.processing_date ';
            $sSql .= 'AND j.score_group_id = k.score_group_id ';
        $sSql .= ');'.PHP_EOL; 
        
        return $sSql;
    }
    
    
    
    protected function removeExpiredEntities()
    {
        $sSql = '';
        $sScoreTmpTable = $this->getScoreTmpTableName();
    
        
        # remove systems that did not exist
        
        $sSql  .= 'DELETE FROM '.$sScoreTmpTable. ' ';
        $sSql  .='WHERE score_ep IS NULL; '.PHP_EOL;
        
        return $sSql;
        
    }
    
    
    
    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            $oDatabase = $this->getDatabaseAdapter();
            
            $sSql = $this->matchScoreEpisodes($oProcessingDate);
            $sSql .= $this->matchScoreGroupsEpisodes($oProcessingDate);
            $sSql .= $this->removeExpiredEntities($oProcessingDate);
            
            
            $oDatabase->executeUpdate($sSql);
            
            
            $oResult->addResult(__CLASS__,'Executed Successfully');
        }
        catch(DBALException $e) {
            $oResult->addError(__CLASS__,$e->getMessage());
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */