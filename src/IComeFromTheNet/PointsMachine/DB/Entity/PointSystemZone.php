<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the points system zone
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class PointSystemZone extends TemporalEntity implements ActiveRecordInterface
{
    
    protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'lengthBetween' => [
            ['system_zone_name','1','100'],['system_zone_name_slug','1','100']
        ]
        ,'slug' => [
            ['system_zone_name_slug']
        ]
        ,'required' => [
            ['system_id','system_zone_name','system_zone_name_slug','enabled_from','enabled_to','system_zone_id']
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
    
    //--------------------------------------------------------------------------
    # Public Properties
   
    
    public $iEpisodeID;
    
    public $sZoneID;
    
    public $sSystemID;
    
    public $sZoneName;
    
    public $sZoneNameSlug;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    //--------------------------------------------------------------------------
    # Entity Hooks
    
    protected function canChangeToSystem($sSystemID) 
    {
        $oGateway          = $this->getTableGateway();
        $oSystemGateway    = $oGateway->getGatewayCollection()->getGateway('pt_system');
        $bResult           = true;
        
        // Check if the system linked is current (Valid in time)
        // rather do this after the insert but that would require a transaction
        // This code too low level to control transactions, as this lib not high throughput system a pre check is not a likely problem.
        if(false === $oSystemGateway->checkSystemIsCurrent($sSystemID,new DateTime('3000-01-01'))) {
            $bResult = false;
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Failed to create new Points System Zone Episode the given Points System is NOT current';
        } 
        
        return $bResult;
    }
    
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        
        if(true === $this->canChangeToSystem($aDatabaseData['system_id'])) {

                $bSuccess = $oGateway->insertQuery()
                 ->start()
                    ->addColumn('system_id'       , $aDatabaseData['system_id'])
                    ->addColumn('zone_id'         , $aDatabaseData['zone_id'])
                    ->addColumn('zone_name'       , $aDatabaseData['zone_name'])
                    ->addColumn('zone_name_slug'  , $aDatabaseData['zone_name_slug'])
                    ->addColumn('enabled_from'    , $aDatabaseData['enabled_from'])
                    ->addColumn('enabled_to'      , $aDatabaseData['enabled_to'])
                 ->end()
                ->insert(); 
        
                if($bSuccess) {
                        
                        $this->aLastResult['result'] = true;
                        $this->aLastResult['msg']    = 'Created new Points System Zone Episode';
                        $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                             
                } else {
                    
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Unable to insert Points System Zone Episode.';
                    
                }
                
                
        } 
            
       return $bSuccess;
    }
    
    protected function createNewEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
     
        $oNow = $oGateway->getNow();
        $aDatabaseData['enabled_to'] = $oNow;
      
            
        if(true === $this->closeEpisode($aDatabaseData)) {
        
            $aDatabaseData['enabled_from']  = $oNow;
            $aDatabaseData['enabled_to']    = new DateTime('3000-01-01');  
            
            # up to the caller to rollback
            if(false === $this->createNewEntity($aDatabaseData)) {
                throw new PointsMachineException($this->aLastResult['msg']);
            }
            
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close the previous episode for system '.$this->sSystemID;
            
        }
        
        
        return $this->aLastResult['result'];
    }
    
    
    protected function updateExistingEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
       
        # new episode on new entity
        
        if(true === $this->canChangeToSystem($aDatabaseData['system_id'])) {
            
             $bSuccess = $oGateway->updateQuery()
                 ->start()
                    ->addColumn('system_id'       , $aDatabaseData['system_id'])
                    ->addColumn('zone_name'       , $aDatabaseData['zone_name'])
                    ->addColumn('zone_name_slug'  , $aDatabaseData['zone_name_slug'])
                ->where()
                    ->filterByEpisode($aDatabaseData['episode_id'])
                    ->filterByZone($aDatabaseData['zone_id'])
                 ->end()
               ->update(); 
               
        
             if($bSuccess) {
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Updated existing Points System Zone Episode';
                
            } else {
                $this->aLastResult['result'] = false;
                $this->aLastResult['msg']    = 'Unable to update existing Points System Zone Episode.';
            }
            
        } 
        

       return $bSuccess;
        
        
    }
    
    protected function checkTemportalFK($aDatabaseData)
    {
        $oGateway              = $this->getTableGateway();
        $oRuleZonesGateway     = $oGateway->getGatewayCollection()->getGateway('pt_rule_sys_zone');
        
        # Check for Referential integrity in time (Is there a 'current' record where this zone is related to a adjustment rule)
        $bReqZone = $oRuleZonesGateway->checkZoneIsCurrent($this->sZoneID);
        
        return array('AdjustmentZone' => $bReqZone);
    }
    
    
    protected function closeEpisode($aDatabaseData)
    {
        $oGateway              = $this->getTableGateway();
        
        $bSuccess = $oGateway->updateQuery()
                             ->start()
                                ->addColumn('enabled_to' , $aDatabaseData['enabled_to'])
                              ->where()
                                ->filterByEpisode($aDatabaseData['episode_id'])
                                ->filterBySystem($aDatabaseData['system_id'])
                                ->filterByCurrent(new DateTime('3000-01-01'))
                             ->end()
                           ->update(); 

        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Closed this episode';
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close this episode';
        }
        
        return $bSuccess;
    }
    
    //--------------------------------------------------------------------------
    # Validation Hooks
    
    protected function getDataForValidation()
    {
        return array(
            'episode_id'            => $this->iEpisodeID
            ,'system_zone_id'       => $this->sZoneID
            ,'system_zone_name'     => $this->sZoneName
            ,'system_zone_name_slug'=> $this->sZoneNameSlug
            ,'enabled_from'         => $this->oEnabledFrom
            ,'enabled_to'           => $this->oEnabledTo
            ,'system_id'            => $this->sSystemID
        );
    }
    
    
    protected function validateNewEpisode($aDatabaseData)
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        // we need the episode if going to create new episode
        array_push($aRules['required'],['episode_id']);
        
        
        return $this->validate($aData,$aRules);
    }
   
    protected function validateNew($aDatabaseData)
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        return $this->validate($aData,$aRules);
    }
    
    protected function validateUpdate($aDatabaseData)
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        // we need the episode if to do an update
        array_push($aRules['required'],['episode_id']);
        
        
        return $this->validate($aData,$aRules);
    }
          
    protected function validateRemove($aDatabaseData)
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        // we need the episode if to do an remove
        array_push($aRules['required'],['episode_id']);
        
        return $this->validate($aData,$aRules);
    }
    
    
   
    
}
/* End of File */

