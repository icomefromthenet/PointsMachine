<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Rule Chains Members
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class RuleChainMember extends TemporalEntity
{
    protected $aValidation = [
       'integer' => [
            ['episode_id','order_seq']
        ]
        ,'required' => [
            ['rule_chain_id','adjustment_group_id','chain_member_id','enabled_from','enabled_to','order_seq']
        ]
        ,'instanceOf' => [
            ['enabled_from','DateTime'],['enabled_to','DateTime']
        ]
        ,'min' => [
           ['episode_id',1],['order_seq',0]
        ]
        ,'max' => [
           ['episode_id',4294967295],['order_seq',1000000]
        ]
            
    ];
    
    
    //---------------------------------------------------------------
    
    public $iEpisodeID;
    
    public $sRuleChainMemberID;
    
    public $sRuleChainID;
    
    public $sAdjustmentGroupID;

    public $iOrderSeq;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    // optional fields display only
    
    public $sRuleChainName;
    
    public $sAdjustmentGroupName;
    
    
    //--------------------------------------------------------------------------
    # Entity Hooks
   
   protected function checkCreateTemportalFK($aDatabaseData) 
    {
        $oGateway          = $this->getTableGateway();
        $oAdjGroupGateway  = $oGateway->getGatewayCollection()->getGateway('pt_rule_group');
        $oRuleChainGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_chain');
        
        
        $bResult      = array();
        $sAdjGroupId  = $aDatabaseData['rule_group_id']; 
        $sChainId     = $aDatabaseData['rule_chain_id'];
        
        if(false === $oAdjGroupGateway->checkAdjGroupIsCurrent($sAdjGroupId)) {
            $bResult['AdjustmentGroup'] = true;
        } 
        
        if(false === $oRuleChainGateway->checkRuleChainIsCurrent($sChainId) ) {
            $bResult['RuleChain'] = true;
        }
        
        return $bResult;
    }
    
    
    protected function checkRemoveTemportalFK($aDatabaseData)
    {
        return array();
    }
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        $bSuccess = $oGateway->insertQuery()
         ->start()
            ->addColumn('chain_member_id'  , $aDatabaseData['chain_member_id'])
            ->addColumn('rule_chain_id'    , $aDatabaseData['rule_chain_id'])
            ->addColumn('rule_group_id'    , $aDatabaseData['rule_group_id'])
            ->addColumn('order_seq'        , $aDatabaseData['order_seq'])
            ->addColumn('enabled_from'     , $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to'       , $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new RuleChainMember Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert RuleChainMember Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new RuleChainMember episode as unable to close the earlier episode';
            
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
                ->addColumn('rule_chain_id'    , $aDatabaseData['rule_chain_id'])
                ->addColumn('rule_group_id'    , $aDatabaseData['rule_group_id'])
                ->addColumn('order_seq'        , $aDatabaseData['order_seq'])
            ->where()
                ->filterByEpisode($aDatabaseData['episode_id'])
                ->filterByChainMember($aDatabaseData['chain_member_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing RuleChainMember Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing RuleChainMember Episode';
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
                                ->filterByChainMember($aDatabaseData['chain_member_id'])
                                ->filterByCurrent(new DateTime('3000-01-01'))
                             ->end()
                           ->update(); 

        if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Closed this RuleChainMember episode';
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to close this RuleChainMember episode';
        }
        
        return $bSuccess;
    }
    
    //--------------------------------------------------------------------------
    # Validation Hooks
    
    protected function getDataForValidation()
    {
        
        return array(
            'episode_id'           => $this->iEpisodeID
            ,'rule_chain_id'       => $this->sRuleChainMemberID
            ,'chain_member_id'     => $this->sRuleChainID
            ,'adjustment_group_id' => $this->sAdjustmentGroupID
            ,'order_seq'           => $this->iOrderSeq
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

