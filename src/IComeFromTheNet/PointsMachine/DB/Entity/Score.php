<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\TemporalEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the scores 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class Score extends TemporalEntity implements ActiveRecordInterface
{
    
    protected $aValidation = [
       'integer' => [
            ['episode_id']
        ]
        ,'lengthBetween' => [
            ['score_name','1','100'],['score_name_slug','1','100']
        ]
        ,'slug' => [
            ['group_name_slug']
        ]
        ,'required' => [
            ['score_id','score_group_id','score_name','score_name_slug','enabled_from','enabled_to','score_value']
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
            ['score_value']    
        ]
        
    ];
    
    //--------------------------------------------------------------------------
    # Public Properties
    
    
    public $iEpisodeID;
    
    public $sScoreID;

    public $sScoreGroupID;

    public $sScoreName;
    
    public $sScoreNameSlug;

    public $fScoreValue;

    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    //--------------------------------------------------------------------------
    # Entity Hooks
    
    protected function checkCreateTemportalFK($aDatabaseData) 
    {
        $oGateway           = $this->getTableGateway();
        $oScoreGroupGateway = $oGateway->getGatewayCollection()->getGateway('pt_score_group');
        $bResult            = array();
        $sScoreGroupID      = $aDatabaseData['score_group_id'];
        
        // Check if the score group linked is current (Valid in time)
        // rather do this after the insert but that would require a transaction
        if(false === $oScoreGroupGateway->checkScoreGroupCurrent($sScoreGroupID,new DateTime('3000-01-01'))) {
            $bResult['ScoreGroup'] = true;
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
            ->addColumn('score_id'         , $aDatabaseData['score_id'])
            ->addColumn('score_group_id'   , $aDatabaseData['score_group_id'])
            ->addColumn('score_name'       , $aDatabaseData['score_name'])
            ->addColumn('score_name_slug'  , $aDatabaseData['score_name_slug'])
            ->addColumn('enabled_from'     , $aDatabaseData['enabled_from'])
            ->addColumn('enabled_to'       , $aDatabaseData['enabled_to'])
            ->addColumn('score_value'      , $aDatabaseData['score_value'])
         ->end()
        ->insert(); 

        if($bSuccess) {
                
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Created new Score Episode';
                $this->iEpisodeID            =  (int) $oGateway->lastInsertId();
                     
        } else {
            
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to insert Score Episode.';
            
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
            $this->aLastResult['msg']    = 'Unable to create new Score episode as unable to close the earlier episode';
            
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
                    ->addColumn('score_name'       , $aDatabaseData['score_name'])
                    ->addColumn('score_name_slug'  , $aDatabaseData['score_name_slug'])
                    ->addColumn('score_value'      , $aDatabaseData['score_value'])   
                    ->addColumn('score_group_id'   , $aDatabaseData['score_group_id'])   
                ->where()
                    ->filterByEpisode($aDatabaseData['episode_id'])
                    ->filterByScore($aDatabaseData['score_id'])
             ->end()
           ->update(); 
           
    
         if($bSuccess) {
            $this->aLastResult['result'] = true;
            $this->aLastResult['msg']    = 'Updated existing Score Episode';
            
        } else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg']    = 'Unable to update existing Score Episode';
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
                                ->filterByScore($aDatabaseData['score_id'])
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
             'episode_id'        => $this->iEpisodeID
            ,'score_id'          => $this->sScoreID 
            ,'score_name'        => $this->sScoreName
            ,'score_name_slug'   => $this->sScoreNameSlug
            ,'enabled_from'      => $this->oEnabledFrom
            ,'enabled_to'        => $this->oEnabledTo
            ,'score_group_id'    => $this->sScoreGroupID
            ,'score_value'       => $this->fScoreValue
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

