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
 * 1. Match system to their current episode and remove if none found.
 * 2. Match system zones to their current episode.
 * 3. Match event types to their current episode and remove if none found.
 * 4. Match the processing chanin with current episode
 * 
 * This throw an error if no rule processing chain is found.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class CommonFilterPass extends AbstractPass 
{
    
    
    
    
    protected function matchSystemsEpisodes(DateTime $oProcessingDate)
    {
        
        $sCommonTmpTable = $this->getCommonTmpTableName();
         $sSql           = '';  
        $sSystemTable    = $this->getGatewayCollection()
                            ->getGateway('pt_system')
                            ->getMetaData()
                            ->getName();                    
        
                            
        # find system entities episodes
        # where using closed-open date pairs
        $sSql .=  'UPDATE '.$sCommonTmpTable.' k ';
        $sSql .= 'SET  k.system_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sSystemTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.system_id = k.system_id ';
        $sSql .= '); '.PHP_EOL;
        
       return $sSql;                         
        
    }
    
   
    
    protected function matchSystemZonesEpisodes(DateTime $oProcessingDate)
    {
        $sCommonTmpTable = $this->getCommonTmpTableName();
        $sSql      = '';  
        $sZoneTable  = $this->getGatewayCollection()
                            ->getGateway('pt_system_zone')
                            ->getMetaData()
                            ->getName();  
        
        # find score group episode
        # where using closed-open date pairs
        $sSql .=  'UPDATE '.$sCommonTmpTable.' ';
        $sSql .= 'SET  system_zone_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sZoneTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= processing_date AND j.enabled_to > processing_date ';
            $sSql .= 'AND j.zone_id = system_zone_id ';
        $sSql .= '); '.PHP_EOL;
    
        return $sSql;
    }
    
    protected function matchEventTypesEpisodes(DateTime $oProcessingDate)
    {
        $sSql      = '';  
        $sCommonTmpTable = $this->getCommonTmpTableName();
        
        $sEtypeTable  = $this->getGatewayCollection()
                            ->getGateway('pt_event_type')
                            ->getMetaData()
                            ->getName();  
        
        # find score group episode
        # where using closed-open date pairs
        $sSql .=  'UPDATE '.$sCommonTmpTable.' k ';
        $sSql .= 'SET  k.event_type_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sEtypeTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.event_type_id = k.event_type_id ';
        $sSql .= '); '.PHP_EOL;
    
        return $sSql;
    }
    
    protected function matchRuleChainEpisodes(DateTime $oProcessingDate)
    {
        $sCommonTmpTable = $this->getCommonTmpTableName();
        $sSql      = '';  
        $sChainTable  = $this->getGatewayCollection()
                            ->getGateway('pt_rule_chain')
                            ->getMetaData()
                            ->getName();  
        
        
        # find the chain that applies to this combination
        
        $sSql .=  'UPDATE '.$sCommonTmpTable.' k ';
        $sSql .= 'SET  k.rule_chain_id = (';
            $sSql .= 'SELECT distinct j.rule_chain_id ';
            $sSql .= 'FROM  '.$sChainTable.' j ';
            $sSql .= 'WHERE j.system_id = k.system_id ';
            $sSql .= 'AND j.event_type_id = k.event_type_id ';
            
        $sSql .= '); '.PHP_EOL;
        
        # find the chain episode
        
        $sSql .=  'UPDATE '.$sCommonTmpTable.' k ';
        $sSql .= 'SET  k.rule_chain_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sChainTable.' j ';
            $sSql .= 'WHERE  j.enabled_from <= k.processing_date AND j.enabled_to > k.processing_date ';
            $sSql .= 'AND j.rule_chain_id = k.rule_chain_id ';
        $sSql .= '); '.PHP_EOL;
     
        return $sSql;
    }
    
    
    protected function removeExpiredEntities(DateTime $oProcessingDate)
    {
        $sSql      = '';  
        $sCommonTmpTable = $this->getCommonTmpTableName();
    
        # remove systems that did not exist
        
        $sSql  .= 'DELETE FROM '.$sCommonTmpTable. ' ';
        $sSql  .='WHERE system_ep IS NULL ';
        $sSql  .='OR event_type_ep IS NULL ';
        $sSql  .='OR rule_chain_ep IS NULL; ';
       
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
        
            $oDatabase = $this->getDatabaseAdaper();
            $sSql      = '';    
        
            $sSql .= $this->matchSystemsEpisodes($oProcessingDate);
            
            $sSql .= $this->matchSystemZonesEpisodes($oProcessingDate);
            
            $sSql .= $this->matchEventTypesEpisodes($oProcessingDate);
            
            $sSql .= $this->matchRuleChainEpisodes($oProcessingDate);
            
            $sSql .= $this->removeExpiredEntities($oProcessingDate);
            
            
            
            $oDatabase->executeUpdate($sSql);
            
        }
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */