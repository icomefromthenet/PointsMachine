<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the score rule groups
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentGroup extends TemporalEntity 
{
    
      
    protected $aValidation = [
       'integer' => [
            ['episode_id'],['max_count']
        ]
        ,'boolean' => [
            ['is_mandatory']
        ]
        ,'lengthBetween' => [
            ['group_name','1','100'],['group_name_slug','1','100']
        ]
        ,'slug' => [
            ['group_name_slug']
        ]
        ,'required' => [
            ['adj_group_id','group_name','group_name_slug','enabled_from','enabled_to']
        ]
        ,'instanceOf' => [
            ['enabled_from','DateTime'],['enabled_to','DateTime']
        ]
        ,'min' => [
           ['episode_id',1],['max_count',1],['order_method',0]
        ]
        ,'max' => [
           ['episode_id',4294967295],['max_count',1000],['order_method',1]
        ]
        ,'numeric' => [
            ['max_modifier'],['min_modifier'],['max_multiplier'],['min_multiplier']
        ]
        
    ];
   
    
    public $iEpisodeID;
    
    public $sAdjustmentGroupID;
    
    public $sGroupName;
    
    public $sGroupNameSlug;

    public $fMaxMultiplier;
    
    public $fMinMultiplier;
    
    public $fMaxModifier;
    
    public $fMinModifier;
    
    public $iMaxCount;
    
    public $iOrderMethod;
    
    public $bIsMandatory;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    
    //--------------------------------------------------------------------------
    # Entity Hooks
   
    
    protected function checkRemoveTemportalFK($aDatabaseData)
    {
        $oGateway               = $this->getTableGateway();
        $oRuleGroupLimitGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oRuleGatway            =  $oGateway->getGatewayCollection()->getGateway('pt_rule'); 
        $oChainMemberGateway    =  $oGateway->getGatewayCollection()->getGateway('pt_chain_member'); 
        
        $bResult           = array();
        $sAdjGroupId       = $aDatabaseData['rule_group_id'];
        
        
        if(true === $oChainMemberGateway->checkParentAdjGroupRequired($sAdjGroupId)) {
            $bResult['RuleChainMember'] = true;
        } 
        
        if(true === $oRuleGatway->checkParentAdjGroupRequired($sAdjGroupId)) {
            $bResult['AdjustmentRule'] = true;
        }
        
        if(true === $oRuleGroupLimitGateway->checkParentAdjGroupRequired($sAdjGroupId)) {
            $bResult['RuleLimit'] = true;
        }
        
        return $bResult;
    }
    
    protected function checkCreateTemportalFK($aDatabaseData) 
    {
        return array();
    }
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        $bSuccess = $oGateway->insertQuery()
         ->start()
            ->addColumn('rule_group_id',        $aDatabaseData['rule_group_id'])
            ->addColumn('rule_group_name',      $aDatabaseData['rule_group_name'])
            ->addColumn('rule_group_name_slug', $aDatabaseData['rule_group_name_slug'])
            ->addColumn('max_multiplier',       $aDatabaseData['max_multiplier'])
            ->addColumn('min_multiplier',       $aDatabaseData['min_multiplier'])
            ->addColumn('max_modifier',         $aDatabaseData['max_modifier'])
            ->addColumn('min_modifier',         $aDatabaseData['min_modifier'])
            ->addColumn('max_count',            $aDatabaseData['max_count'])
            ->addColumn('order_method',         $aDatabaseData['order_method'])
            ->addColumn('is_mandatory',         $aDatabaseData['is_mandatory'])
            ->addColumn('enabled_from',         $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to',           $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new AdjustmentGroup Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert AdjustmentGroup Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new AdjustmentGroup episode as unable to close the earlier episode';
            
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
                ->addColumn('rule_group_name',      $aDatabaseData['rule_group_name'])
                ->addColumn('rule_group_name_slug', $aDatabaseData['rule_group_name_slug'])
                ->addColumn('max_multiplier',       $aDatabaseData['max_multiplier'])
                ->addColumn('min_multiplier',       $aDatabaseData['min_multiplier'])
                ->addColumn('max_modifier',         $aDatabaseData['max_modifier'])
                ->addColumn('min_modifier',         $aDatabaseData['min_modifier'])
                ->addColumn('max_count',            $aDatabaseData['max_count'])
                ->addColumn('order_method',         $aDatabaseData['order_method'])
                ->addColumn('is_mandatory',         $aDatabaseData['is_mandatory'])
            ->where()
                ->filterByEpisode($aDatabaseData['episode_id'])
                ->filterByAdjustmentGroup($aDatabaseData['rule_group_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing AdjustmentGroup Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing AdjustmentGroup Episode';
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
                                ->filterByAdjustmentGroup($aDatabaseData['rule_group_id'])
                                ->filterByCurrent(new DateTime('3000-01-01'))
                             ->end()
                           ->update(); 

        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Closed this AdjustmentGroup episode';
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close this AdjustmentGroup episode';
        }
        
        return $bSuccess;
    }
    
    //--------------------------------------------------------------------------
    # Validation Hooks
    
    protected function getDataForValidation()
    {
        return array(
             'episode_id'        => $this->iEpisodeID
            ,'adj_group_id'      => $this->sAdjustmentGroupID
            ,'group_name'        => $this->sGroupName
            ,'group_name_slug'   => $this->sGroupNameSlug
            ,'min_multiplier'    => $this->fMinMultiplier
            ,'max_multiplier'    => $this->fMaxMultiplier
            ,'min_modifier'      => $this->fMinModifier
            ,'max_modifier'      => $this->fMaxModifier
            ,'max_count'         => $this->iMaxCount
            ,'order_method'      => $this->iOrderMethod
            ,'is_mandatory'      => $this->bIsMandatory        
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

