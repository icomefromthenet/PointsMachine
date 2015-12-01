<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use Valitron\Validator;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;


/**
 * Entity for the points system
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class PointSystem extends  TemporalEntity implements ActiveRecordInterface
{
    
    
    
    protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'lengthBetween' => [
            ['system_name','1','100'],['system_name_slug','1','100']
        ]
        ,'slug' => [
            ['system_name_slug']
        ]
        ,'required' => [
            ['system_id','system_name','system_name_slug','enabled_from','enabled_to']
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
    
    public $sSystemID;
    
    public $sSystemName;
    
    public $sSystemNameSlug;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    
    //--------------------------------------------------------------------------
    # Entity Hooks
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
       
            
       
        # new episode on new entity
        $bSuccess = $oGateway->insertQuery()
                 ->start()
                    ->addColumn('episode_id'      , null)
                    ->addColumn('system_id'       , $aDatabaseData['system_id'])
                    ->addColumn('system_name'     , $aDatabaseData['system_name'])
                    ->addColumn('system_name_slug', $aDatabaseData['system_name_slug'])
                    ->addColumn('enabled_from'    , $aDatabaseData['enabled_from'])
                    ->addColumn('enabled_to'      , $aDatabaseData['enabled_to'])
                 ->end()
               ->insert(); 

    

        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Created new Points System Episode';
            
            $this->iEpisodeID =  (int) $oGateway->lastInsertId();
            
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert Points System Episode.';
        }
        
        
       return $bSuccess;
    }
    
    protected function createNewEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
     
        $oNow = $oGateway->getNow();
      
            # stop the last entity
            $bUpdated = $oGateway->updateQuery()
                    ->start()
                        ->addColumn('enabled_to',$oNow)
                    ->where()
                        ->filterByEpisode($aDatabaseData['episode_id'])
                    ->end()
                ->update();
            
            if(true === $bUpdated) {
            
                $aDatabaseData['enabled_from'] = $oNow;
                $bSuccess = $this->createNewEntity($aDatabaseData);
            
                
            } else {
                
                $this->aLastResult['result'] = false;
                $this->aLastResult['msg']    = 'Unable to close the previous episode for system '.$this->sSystemID;
                
            }
        
        
        return $bSuccess;
    }
    
    
    protected function updateExistingEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
       
        # new episode on new entity
        $bSuccess = $oGateway->updateQuery()
                 ->start()
                    ->addColumn('system_id'       , $aDatabaseData['system_id'])
                    ->addColumn('system_name'     , $aDatabaseData['system_name'])
                    ->addColumn('system_name_slug', $aDatabaseData['system_name_slug'])
                ->where()
                    ->filterByEpisode($aDatabaseData['episode_id'])
                    ->filterBySystem($aDatabaseData['system_id'])
                 ->end()
               ->update(); 


        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing Points System Episode';
            
            $this->iEpisodeID = (int) $oGateway->lastInsertId();
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing Points System Episode.';
        }
        
        
       return $bSuccess;
        
        
    }
    
    protected function checkTemportalFK($aDatabaseData)
    {
        $oGateway              = $this->getTableGateway();
        $oRuleChainGateway     = $oGateway->getGatewayCollection()->getGateway('pt_rule_chain');
        $oSystemZoneGateway    = $oGateway->getGatewayCollection()->getGateway('pt_system_zone');
        $oAdjGroupLimitGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oBuilder              = $oGateway->getEntityBuilder();
        
        # Check for Referential integrity in time 
        $bReqSystemZone = $oSystemZoneGateway->checkParentSystemRequired($this->sSystemID);
        $bReqAdjGroup   =   $oAdjGroupLimitGateway->checkParentSystemRequired($this->sSystemID);
        $bReqRuleChain  = $oAdjGroupLimitGateway->checkParentSystemRequired($this->sSystemID);
         
        
        return array('SystemZone' => $bReqSystemZone,'AdjustmentGroup' => $bReqAdjGroup, 'RuleChain' => $bReqRuleChain);
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
                                ->whereEnabledAfterNow()
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
            'episode_id' => $this->iEpisodeID
            ,'system_id'  => $this->sSystemID
            ,'system_name' => $this->sSystemName
            ,'system_name_slug' => $this->sSystemNameSlug
            ,'enabled_from' => $this->oEnabledFrom
            ,'enabled_to' => $this->oEnabledTo
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

