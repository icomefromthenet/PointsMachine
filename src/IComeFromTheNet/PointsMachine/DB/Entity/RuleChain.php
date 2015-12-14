<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Rule Chains
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class RuleChain extends TemporalEntity
{
    
    protected $aValidation = [
       'integer' => [
            ['episode_id','rounding_option']
        ]
        ,'lengthBetween' => [
            ['chain_name','1','100'],['chain_name_slug','1','100']
        ]
        ,'slug' => [
            ['chain_name_slug']
        ]
        ,'required' => [
            ['rule_chain_id','system_id','event_type_id','chain_name','chain_name_slug','enabled_from','enabled_to','rounding_option']
        ]
        ,'instanceOf' => [
            ['enabled_from','DateTime'],['enabled_to','DateTime']
        ]
        ,'min' => [
           ['episode_id',1],['rounding_option',0]
        ]
        ,'max' => [
           ['episode_id',4294967295],['rounding_option',3]
        ]
        ,'numeric' => [
            ['cap_value']
        ]
        
    ];
   
    //--------------------------------------------------------------------------
    # Public Properties
   
   
    public $iEpisodeID;
    
    public $sRuleChainID;
    
    public $sEventTypeID;
    
    public $sSystemID;
    
    public $sChainName;
    
    public $sChainNameSlug;

    public $iRoundingOption;
    
    public $fCapValue;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    //--------------------------------------------------------------------------
    # Entity Hooks
   
   protected function checkCreateTemportalFK($aDatabaseData) 
    {
        $oGateway          = $this->getTableGateway();
        $oSystemGateway    = $oGateway->getGatewayCollection()->getGateway('pt_system');
        $oEventTypeGateway = $oGateway->getGatewayCollection()->getGateway('pt_event_type');
        
        $bResult           = array();
        $sSystemID         = $aDatabaseData['system_id'];
        $sEventTypeID      = $aDatabaseData['event_type_id'];
        
        if(false === $oSystemGateway->checkSystemIsCurrent($sSystemID,new DateTime('3000-01-01'))) {
            $bResult['System'] = true;
        } 
        
        if(false === $oEventTypeGateway->checkEventTypeIsCurrent($sEventTypeID,new DateTime('3000-01-01'))) {
            $bResult['EventType'] = true;
        } 
        
        return $bResult;
    }
    
    
    protected function checkRemoveTemportalFK($aDatabaseData)
    {
        $oGateway            = $this->getTableGateway();
        $oChainMemberGateway = $oGateway->getGatewayCollection()->getGateway('pt_chain_member');
        
        $bResult           = array();
        $sChainMemberId    = $aDatabaseData['rule_chain_id'];
        
        
        if(true === $oChainMemberGateway->checkParentChainRequired($sChainMemberId)) {
            $bResult['RuleChainMember'] = true;
        } 
        
        return $bResult;
    }
    
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        $bSuccess = $oGateway->insertQuery()
         ->start()
            ->addColumn('rule_chain_id'    , $aDatabaseData['rule_chain_id'])
            ->addColumn('event_type_id'    , $aDatabaseData['event_type_id'])
            ->addColumn('system_id'        , $aDatabaseData['system_id'])
            ->addColumn('chain_name'       , $aDatabaseData['chain_name'])
            ->addColumn('chain_name_slug'  , $aDatabaseData['chain_name_slug'])
            ->addColumn('rounding_option'  , $aDatabaseData['rounding_option'])
            ->addColumn('cap_value'        , $aDatabaseData['cap_value'])
            ->addColumn('enabled_from'     , $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to'       , $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new RuleChain Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert RuleChain Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new RuleChain episode as unable to close the earlier episode';
            
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
                ->addColumn('event_type_id'     , $aDatabaseData['event_type_id'])
                ->addColumn('system_id'         , $aDatabaseData['system_id'])
                ->addColumn('chain_name'        , $aDatabaseData['chain_name'])   
                ->addColumn('chain_name_slug'   , $aDatabaseData['chain_name_slug'])   
                ->addColumn('rounding_option'   , $aDatabaseData['rounding_option'])
                ->addColumn('cap_value'         , $aDatabaseData['cap_value'])
            ->where()
                ->filterByEpisode($aDatabaseData['episode_id'])
                ->filterByRuleChain($aDatabaseData['rule_chain_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing RuleChain Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing RuleChain Episode';
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
                                ->filterByRuleChain($aDatabaseData['rule_chain_id'])
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
            'episode_id'         => $this->iEpisodeID
            ,'rule_chain_id'     => $this->sRuleChainID
            ,'event_type_id'     => $this->sEventTypeID
            ,'system_id'         => $this->sSystemID
            ,'chain_name'        => $this->sChainName
            ,'chain_name_slug'   => $this->sChainNameSlug
            ,'rounding_option'   => $this->iRoundingOption
            ,'cap_value'         => $this->fCapValue
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

