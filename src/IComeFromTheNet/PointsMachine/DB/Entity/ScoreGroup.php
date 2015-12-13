<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the score groups
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoreGroup extends TemporalEntity implements ActiveRecordInterface
{
    protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'lengthBetween' => [
            ['group_name','1','100'],['group_name_slug','1','100']
        ]
        ,'slug' => [
            ['group_name_slug']
        ]
        ,'required' => [
            ['score_group_id','group_name','group_name_slug','enabled_from','enabled_to']
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
    
    public $sScoreGroupID;
    
    public $sGroupName;
    
    public $sGroupNameSlug;

    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    //--------------------------------------------------------------------------
    # Entity Hooks
    
    
    protected function checkRemoveTemportalFK($aDatabaseData)
    {
        $oGateway               = $this->getTableGateway();
        $oScoreGateway          = $oGateway->getGatewayCollection()->getGateway('pt_score');
        $oAdjGroupLimitGateway  = $oGateway->getGatewayCollection()->getGateway('pt_score');
       
        
        // Check for Referential integrity in time. That is
        // there this score group is related to a 'current' score)
        // to close this score group would invalidate the relation 
        $bReqScore    = $oScoreGateway->checkParentScoreGroupRequired($this->sScoreGroupID);
        $bReqAdjGroup = $oAdjGroupLimitGateway->checkParentScoreGroupRequired($this->sScoreGroupID);
        
        return array('Score' => $bReqScore, 'AdjustmentGroupLimit' => $bReqAdjGroup);
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
            ->addColumn('score_group_id'  , $aDatabaseData['score_group_id'])
            ->addColumn('group_name'       , $aDatabaseData['group_name'])
            ->addColumn('group_name_slug'  , $aDatabaseData['group_name_slug'])
            ->addColumn('enabled_from'    , $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to'      , $aDatabaseData['enabled_to'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new Score Group Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert Score Group Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new Score Group episode as unable to close the earlier episode';
            
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
                    ->addColumn('group_name'       , $aDatabaseData['group_name'])
                    ->addColumn('group_name_slug'  , $aDatabaseData['group_name_slug'])
                ->where()
                    ->filterByEpisode($aDatabaseData['episode_id'])
                    ->filterByScoreGroup($aDatabaseData['score_group_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing Score Group Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing Score Group Episode';
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
                                ->filterByScoreGroup($aDatabaseData['score_group_id'])
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
            'episode_id'          => $this->iEpisodeID
            ,'group_name'         => $this->sGroupName
            ,'group_name_slug'    => $this->sGroupNameSlug
            ,'enabled_from'       => $this->oEnabledFrom
            ,'enabled_to'         => $this->oEnabledTo
            ,'score_group_id'      => $this->sScoreGroupID
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

