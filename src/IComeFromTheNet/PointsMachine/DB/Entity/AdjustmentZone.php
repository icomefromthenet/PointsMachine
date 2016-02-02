<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Adjustemt Zones
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentZone extends TemporalEntity 
{
    
     protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'required' => [
            ['zone_id','rule_id','enabled_from','enabled_to']
        ]
        ,'instanceOf' => [
            ['enabled_from','DateTime'],['enabled_to','DateTime']
        ]
        ,'min' => [
           ['episode_id',1]
        ]
        ,'max' => [
           ['episode_id',4294967295]
        ]
        
    ];
    
    public $iEpisodeID;
    
    public $sAdjustmentRuleID;
    
    public $sSystemZoneID;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
     //--------------------------------------------------------------------------
    # Entity Hooks
   
    
    protected function checkRemoveTemportalFK($aDatabaseData)
    {
       return array();
    }
    
    protected function checkCreateTemportalFK($aDatabaseData) 
    {
        $oGateway               = $this->getTableGateway();
        $oRuleGateway           = $oGateway->getGatewayCollection()->getGateway('pt_rule');
        $oZoneGateway           = $oGateway->getGatewayCollection()->getGateway('pt_system_zone');
        
        $bResult           = array();
        $sAdjGroupId       = $aDatabaseData['rule_id'];
        $sSystemZoneId     = $aDatabaseData['zone_id'];
        
        
        if(false === $oRuleGateway->checkAdjRuleIsCurrent($sAdjGroupId)) {
            $bResult['AdjustmentRule'] = true;
        } 
        
        if(false === $oZoneGateway->checkSystemZoneIsCurrent($sSystemZoneId)) {
            $bResult['SystemZone'] = true;
        }
        
      
        
        return $bResult;
    }
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        $bSuccess = $oGateway->insertQuery()
         ->start()
            ->addColumn('rule_id',          $aDatabaseData['rule_id'])
            ->addColumn('zone_id',          $aDatabaseData['zone_id'])
            ->addColumn('enabled_from',     $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to',       $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new AdjustmentZone Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert AdjustmentZone Episode.';
            
        }


       return $bSuccess;
    }
    
    protected function createNewEpisode($aDatabaseData)
    {
        throw new PointsMachineException('No episodes are possible with this entity');
    }
    
    
    protected function updateExistingEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
       
        # new episode
        
        $bSuccess = $oGateway->updateQuery()
            ->start()
                 ->addColumn('rule_id',          $aDatabaseData['rule_id'])
                 ->addColumn('zone_id',          $aDatabaseData['zone_id'])
            ->where()
                ->filterByEpisode($aDatabaseData['episode_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing AdjustmentZone Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing AdjustmentZone Episode';
        }
        
 
       return $bSuccess;
        
        
    }
    
    
    protected function closeEpisode($aDatabaseData)
    {
        $oGateway              = $this->getTableGateway();
        
        $bSuccess = $oGateway->updateQuery()
                             ->start()
                                ->addColumn('enabled_to' , $aDatabaseData['enabled_to'])
                              ->where()
                                ->filterByEpisode($aDatabaseData['episode_id'])
                                ->filterByAdjustmentRule($aDatabaseData['rule_id'])
                                ->filterBySystemZone($aDatabaseData['zone_id'])
                                ->filterByCurrent(new DateTime('3000-01-01'))
                             ->end()
                           ->update(); 

        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Closed this AdjustmentZone episode';
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close this AdjustmentZone episode';
        }
        
        return $bSuccess;
    }
    
    //--------------------------------------------------------------------------
    # Validation Hooks
    
    protected function getDataForValidation()
    {
        return array(
             'episode_id'        => $this->iEpisodeID
            ,'rule_id'           => $this->sAdjustmentRuleID
            ,'zone_id'           => $this->sSystemZoneID 
            ,'enabled_from'      => $this->oEnabledFrom
            ,'enabled_to'        => $this->oEnabledTo
         
        );
    }
    
    
    protected function validateNewEpisode()
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        // we need the episode if going to create new episode
        array_push($aRules['required'],['episode_id']);
        
        
        return $this->validate($aData,$aRules);
    }
   
    protected function validateNew()
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        return $this->validate($aData,$aRules);
    }
    
    protected function validateUpdate()
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        // we need the episode if to do an update
        array_push($aRules['required'],['episode_id']);
        
        
        return $this->validate($aData,$aRules);
    }
          
    protected function validateRemove()
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        // we need the episode if to do an remove
        array_push($aRules['required'],['episode_id']);
        
        return $this->validate($aData,$aRules);
    }
   
    
    
    
}
/* End of File */

