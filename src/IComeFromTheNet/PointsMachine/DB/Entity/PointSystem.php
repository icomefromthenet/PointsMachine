<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the points system
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class PointSystem extends CommonEntity implements ActiveRecordInterface
{
    
    public $iEpisodeID;
    
    public $sSystemID;
    
    public $sSystemName;
    
    public $sSystemNameSlug;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    
    public function saveEpisode(DateTime $oProcessDte)
    {
        $bSaved            = false;
        $this->aLastResult = array( 'result' => '','msg' =>'');
        $oGateway          = $this->getTableGateway();
        $oBuilder          = $oGateway->getEntityBuilder();
        
        try {
        
            if(false === empty($this->iEpisodeID) && false === empty($this->sSystemID)) {
                # update exsiting allowed columns e.g name
                
                $aDatabaseData = $oBuilder->demolish($this);
                
                $bSuccess = $oGateway->updateQuery()
                         ->start()
                            ->addColumn('system_name'     , $aDatabaseData['system_name'])
                            ->addColumn('system_name_slug', $aDatabaseData['system_name_slug'])
                         ->where()
                            ->filterByEpisode($aDatabaseData['episode_id'])
                            ->filterBySystem($aDatabaseData['system_id'])
                         ->end()
                       ->update(); 
    
                if($bSuccess) {
                    $this->aLastResult['result'] = true;
                    $this->aLastResult['msg']    = 'Updated the non calculation columns for this Points System';
                } else {
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Unable to find Points System Episode or no changes in data';
                }
                
            } elseif(false === empty($this->iEpisodeID) && true === empty($this->sSystemID)) {
                # save new episode, update existing episode with end date
                $aDatabaseData = $oBuilder->demolish($this); 
                    
                
                
            } else {
                # new episode on a new entity
                $aDatabaseData = $oBuilder->demolish($this);
                
                $sSystemId = uniqid('system_');
                
                $bSuccess = $oGateway->insertQuery()
                         ->start()
                            ->addColumn('episode_id',$sSystemId)
                            ->addColumn('system_id',null)
                            
                            ->addColumn('system_name'     , $aDatabaseData['system_name'])
                            ->addColumn('system_name_slug', $aDatabaseData['system_name_slug'])
                         ->end()
                       ->insert(); 
                       
                 if($bSuccess) {
                    $this->aLastResult['result'] = true;
                    $this->aLastResult['msg']    = 'Inserted new Points System Episode';
                } else {
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Unable to insert Points System Episode.';
                }
                
            }
            
        } catch (Exception $e) {
            $this->getAppLogger()->error($e->getMessage());
        
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = $e->getMessage();
        }
        
        return $bSaved;
    }
    
    public function deleteEpisode(DateTime $oProcessDte)
    {
        if(false === empty($this->iEpisodeID) && false === empty($this->sSystemID)) {
            
            # do the update setting the assigned date or the processing date
            $oDate = $oProcessDte;
            
            if(false === empty($this->oEnabledTo)) {
                $oDate = $this->oEnabledTo;
            } 
            
            $this->aLastResult = array( 'result' => '','msg' =>'');
            $oGateway          = $this->getTableGateway();
            $oBuilder          = $oGateway->getEntityBuilder();
            $oDatabase         = $this->oGateway->getAdapter();
        
            $aDatabaseData = $oBuilder->demolish($this);   
           
            $bSuccess = $oGateway->updateQuery()
                         ->start()
                            ->addColumn('enabled_to' , $aDatabaseData['enabled_to'])
                          ->where()
                            ->filterByEpisode($aDatabaseData['episode_id'])
                            ->filterBySystem($aDatabaseData['system_id'])
                         ->end()
                       ->update(); 
    
            if($bSuccess) {
                $this->aLastResult['result'] = true;
                $this->aLastResult['msg']    = 'Deleted this episode';
            } else {
                $this->aLastResult['result'] = false;
                $this->aLastResult['msg']    = 'Unable to delete this episode';
            }
           
            
            # check that removed date follows the enabled date
            $iInvalid = $oGateway->newQueryBuilder()
                     ->select('1')
                     ->from($oGateway->getMetaData()->getName())
                     ->filterBySystem($this->sSystemID)
                     ->filterByEpisode($this->iEpisodeID)
                     ->whereStartDateProceedsStopDate()
                   ->end()
                   ->findColumn(1);
                   
            if($iInvalid == 1) {
                $this->aLastResult['result'] = false;
                $this->aLastResult['msg']    = 'This entities episode has stop date that occurs before it start date and is there for invalid';
                $oDatabase->rollback();            
            } else {       
            
                # check that no overlaps with other episodes of this entity
                  $iInvalid = $oGateway->newQueryBuilder()
                     ->select('1')
                     ->from($oGateway->getMetaData()->getName())
                     ->filterBySystem($this->sSystemID)
                     ->andWhere('')
                   ->end()
                   ->findColumn(1);
            
            
                # check that date not precede the last transaction date for this entity
            }
            
            
        }
        else {
            throw new PointsMachineException('Require and Episode Id and Entity Id to delete and episode');
        }
        
        return $this->aLastResult['result'];
    }
    
    public function validate(DateTime $oProcessDte)
    {
        if(false === empty($this->iEpisodeID) && false === empty($this->sSystemID)) {
            # update exsiting allowed columns e.g name
            return $this->validateUpdate($oProcessDte);
        } elseif(false === empty($this->iEpisodeID) && true === empty($this->sSystemID)) {
            # save new episode, update existing episode with end date
            return $this->validateNewEpisode($oProcessDte);
        } else {
            # new episode on a new entity
            return $this->validateNewEntity($oProcessDte);
        }
         
    }
    
    public function validateNewEpisode(DateTime $oProcessDte)
    {
        
        
    }
    
    
    public function validateNewEntity(DateTime $oProcessDte)
    {
        
        
    }
    
    
    public function validateUpdate(DateTime $oProcessDte)
    {
        
        
    }
    
}
/* End of File */

