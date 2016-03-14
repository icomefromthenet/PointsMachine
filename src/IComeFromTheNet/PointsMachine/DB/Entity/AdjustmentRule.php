<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Adjustemt Rules
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentRule extends TemporalEntity
{
    
     protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'boolean' => [
            ['invert_flag']
        ]
        ,'lengthBetween' => [
            ['rule_name','1','100'],['rule_name_slug','1','100']
        ]
        ,'slug' => [
            ['rule_name_slug']
        ]
        ,'required' => [
            ['adj_rule_id','adj_group_id','rule_name','rule_name_slug','enabled_from','enabled_to']
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
        ,'numeric' => [
            ['multiplier'],['modifier']
        ]
        
    ];
    
    
    public $iEpisodeID;
    
    public $sAdjustmentRuleID;
    
    public $sAdjustmentGroupID;
    
    public $sRuleName;
    
    public $sRuleNameSlug;

    public $fMultiplier;

    public $fModifier;
    
    public $bInvertFlag;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    // Optional fields for display only
    
    public $sAdjustmentGroupName;
    
    
   //--------------------------------------------------------------------------
    # Entity Hooks
   
    
    protected function checkRemoveTemportalFK($aDatabaseData)
    {
        $oGateway               = $this->getTableGateway();
        $oAdjZoneGateway        = $oGateway->getGatewayCollection()->getGateway('pt_rule_sys_zone');
        
        $bResult           = array();
        $sAdjRuleId        = $aDatabaseData['rule_id'];
        
        
        if(true === $oAdjZoneGateway->checkParentAdjRuleRequired($sAdjRuleId)) {
            $bResult['AdjustmentZone'] = true;
        }
        
        return $bResult;
    }
    
    protected function checkCreateTemportalFK($aDatabaseData) 
    {
        $bResult          = array();
        $oGateway         = $this->getTableGateway();
        $oAdjGroupGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_group');
        
        $sAdjGroupId      = $aDatabaseData['rule_group_id'];

        if(false === $oAdjGroupGateway->checkAdjGroupIsCurrent($sAdjGroupId)) {
            $bResult['AdjustmentRuleGroup'] = true;
        }        
        
        return $bResult;
    }
    
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        $bSuccess = $oGateway->insertQuery()
         ->start()
            ->addColumn('rule_id',        $aDatabaseData['rule_id'])
            ->addColumn('rule_group_id',  $aDatabaseData['rule_group_id'])
            ->addColumn('rule_name',      $aDatabaseData['rule_name'])
            ->addColumn('rule_name_slug', $aDatabaseData['rule_name_slug'])
            ->addColumn('multiplier',     $aDatabaseData['multiplier'])
            ->addColumn('modifier',       $aDatabaseData['modifier'])
            ->addColumn('invert_flag',    $aDatabaseData['invert_flag'])
            ->addColumn('enabled_from',   $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to',     $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new AdjustmentRule Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert AdjustmentRule Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new AdjustmentRule episode as unable to close the earlier episode';
            
        }
        
        
        return $this->aLastResult['result'];
    }
    
    
    protected function updateExistingEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
       
        # new episode
        
        $bSuccess = $oGateway->updateQuery()
            ->start()
                ->addColumn('rule_group_id',  $aDatabaseData['rule_group_id'])
                ->addColumn('rule_name',      $aDatabaseData['rule_name'])
                ->addColumn('rule_name_slug', $aDatabaseData['rule_name_slug'])
                ->addColumn('multiplier',     $aDatabaseData['multiplier'])
                ->addColumn('modifier',       $aDatabaseData['modifier'])
                ->addColumn('invert_flag',    $aDatabaseData['invert_flag'])
            ->where()
                ->filterByEpisode($aDatabaseData['episode_id'])
                ->filterByAdjustmentRule($aDatabaseData['rule_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing AdjustmentRule Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing AdjustmentRule Episode';
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
                                ->filterByCurrent(new DateTime('3000-01-01'))
                             ->end()
                           ->update(); 

        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Closed this AdjustmentRule episode';
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close this AdjustmentRule episode';
        }
        
        return $bSuccess;
    }
    
    //--------------------------------------------------------------------------
    # Validation Hooks
    
    protected function getDataForValidation()
    {
    
        
        return array(
             'episode_id'       => $this->iEpisodeID
            ,'adj_rule_id'      => $this->sAdjustmentRuleID
            ,'adj_group_id'     => $this->sAdjustmentGroupID
            ,'rule_name'        => $this->sRuleName
            ,'rule_name_slug'   => $this->sRuleNameSlug
            ,'multiplier'       => $this->fMultiplier
            ,'modifier'         => $this->fModifier 
            ,'invert_flag'      => $this->bInvertFlag
            ,'enabled_from'     => $this->oEnabledFrom
            ,'enabled_to'       => $this->oEnabledTo
          
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

