<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Used to limit AdjustmentGroup to a ScoreGroup/System
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentGroupLimit extends TemporalEntity
{
    
    protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'required' => [
            ['rule_group_id','enabled_from','enabled_to']
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
    
    public $sAdjustmentGroupID;
    
    public $sScoreGroupID;
    
    public $sSystemID;
    
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
        $oAdjRuleGroupGateway   = $oGateway->getGatewayCollection()->getGateway('pt_rule_group');
        $oSystemGateway         = $oGateway->getGatewayCollection()->getGateway('pt_system');
        $oScoreGroupGateway     = $oGateway->getGatewayCollection()->getGateway('pt_score_group');
        
        $bResult           = array();
        $sAdjGroupId       = $aDatabaseData['rule_group_id'];
        $sSystemId         = $aDatabaseData['system_id'];
        $sScoreGroupId     = $aDatabaseData['score_group_id'];     
        
        
        if(false === $oAdjRuleGroupGateway->checkAdjGroupIsCurrent($sAdjGroupId)) {
            $bResult['AdjustmentRuleGroup'] = true;
        } 
        
        if(false === empty($sSystemId) && false === $oSystemGateway->checkSystemIsCurrent($sSystemId)) {
            $bResult['System'] = true;
        }
        
        if(false === empty($sScoreGroupId) && false === $oScoreGroupGateway->checkScoreGroupIsCurrent($sScoreGroupId)) {
            $bResult['ScoreGroup'] = true;
        }
        
        return $bResult;
    }
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        $bSuccess = $oGateway->insertQuery()
         ->start()
            ->addColumn('rule_group_id',    $aDatabaseData['rule_group_id'])
            ->addColumn('score_group_id',   $aDatabaseData['score_group_id'])
            ->addColumn('system_id',        $aDatabaseData['system_id'])
            ->addColumn('enabled_from',     $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to',       $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new AdjustmentGroupLimit Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert AdjustmentGroupLimit Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new AdjustmentGroupLimit episode as unable to close the earlier episode';
            
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
                ->addColumn('score_group_id',   $aDatabaseData['score_group_id'])
                ->addColumn('system_id',        $aDatabaseData['system_id'])
            ->where()
                ->filterByEpisode($aDatabaseData['episode_id'])
                ->filterByAdjustmentGroup($aDatabaseData['rule_group_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing AdjustmentGroupLimit Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing AdjustmentGroupLimit Episode';
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
            $this->aLastResult['msg']    = 'Closed this AdjustmentGroupLimit episode';
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close this AdjustmentGroupLimit episode';
        }
        
        return $bSuccess;
    }
    
    //--------------------------------------------------------------------------
    # Validation Hooks
    
    protected function getDataForValidation()
    {
        return array(
             'episode_id'        => $this->iEpisodeID
            ,'rule_group_id'     => $this->sAdjustmentGroupID
            ,'score_group_id'    => $this->sScoreGroupID
            ,'system_id'         => $this->sSystemID 
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
        
        if(true === empty($this->sScoreGroupID)) {
            array_push($aRules['required'],['system_id']);
        }
        else {
            array_push($aRules['required'],['score_group_id']);
        }
        
        return $this->validate($aData,$aRules);
    }
    
    protected function validateUpdate()
    {
        $aData = $this->getDataForValidation();
        $aRules = $this->aValidation;
        
        // we need the episode if to do an update
        array_push($aRules['required'],['episode_id']);
        
        if(true === empty($this->sScoreGroupID)) {
            array_push($aRules['required'],['system_id']);
        }
        else {
            array_push($aRules['required'],['score_group_id']);
        }
        
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

