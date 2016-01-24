<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the event types
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class EventType extends TemporalEntity
{
    
    protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'required' => [
            ['event_type_id','event_name','event_name_slug','enabled_from','enabled_to']
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
        ,'slug' => [
         ['event_name_slug']
        ]
            
    ];
    
    //--------------------------------------------------------------------------
    
    public $iEpisodeID;
    
    public $sEventTypeID;
    
    public $sEventName;
    
    public $sEventNameSlug;

    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    //--------------------------------------------------------------------------
    # Entity Hooks
   
   protected function checkCreateTemportalFK($aDatabaseData) 
   {
        return array();    
   }
    
    
    protected function checkRemoveTemportalFK($aDatabaseData)
    {
        $oGateway          = $this->getTableGateway();
        $oRuleChainGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_chain');
        
        $bResult      = array();
        
       if(true === $oRuleChainGateway->checkParentEventTypeRequired($this->sEventTypeID)) {
           $bResult['RuleChain'] = true;
       }
       
        
        return $bResult;
    }
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        $bSuccess = $oGateway->insertQuery()
         ->start()
            ->addColumn('event_type_id'    , $aDatabaseData['event_type_id'])
            ->addColumn('event_name'       , $aDatabaseData['event_name'])
            ->addColumn('event_name_slug'  , $aDatabaseData['event_name_slug'])
            ->addColumn('enabled_from'     , $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to'       , $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new EventType Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert EventType Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new EventType episode as unable to close the earlier episode';
            
        }
        
        
        return $this->aLastResult['result'];
    }
    
    
    protected function updateExistingEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
       
        # new episode on new entity
        
        $bSuccess = $oGateway->updateQuery()
            ->start()
                ->addColumn('event_name'       , $aDatabaseData['event_name'])
                ->addColumn('event_name_slug'  , $aDatabaseData['event_name_slug'])
            ->where()
                ->filterByEpisode($aDatabaseData['episode_id'])
                ->filterByEventType($aDatabaseData['event_type_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing EventType Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing EventType Episode';
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
                                ->filterByEventType($aDatabaseData['event_type_id'])
                                ->filterByCurrent(new DateTime('3000-01-01'))
                             ->end()
                           ->update(); 

        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Closed this EventType episode';
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close this EventType episode';
        }
        
        return $bSuccess;
    }
    
    //--------------------------------------------------------------------------
    # Validation Hooks
    
    protected function getDataForValidation()
    {
        return array(
            'episode_id'           => $this->iEpisodeID
            ,'event_type_id'       => $this->sEventTypeID
            ,'event_name'          => $this->sEventName
            ,'event_name_slog'     => $this->sEventNameSlug
            ,'enabled_from'        => $this->oEnabledFrom
            ,'enabled_to'          => $this->oEnabledTo
          
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

