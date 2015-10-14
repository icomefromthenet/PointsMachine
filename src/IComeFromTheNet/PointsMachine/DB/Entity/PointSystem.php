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
    
    
    
    public function save(DateTime $oProcessDte)
    {
        $bSuccess          = false;
        $this->aLastResult = array( 'result' => '','msg' =>'');
        $oGateway          = $this->getTableGateway();
        $oBuilder          = $oGateway->getEntityBuilder();
        
                
        try {
        
            $this->oEnabledFrom = $oGateway->getNow();
            $this->oEnabledTo   = DateTime::createFromFormat('d-m-Y','01-01-3000');
            $aDatabaseData     = $oBuilder->demolish($this);
        
        
            if(true === empty($this->iEpisodeID)) {
                
                # new episode on new entity
                $bSuccess = $oGateway->insertQuery()
                         ->start()
                            ->addColumn('system_id'       , $aDatabaseData['system_id'])
                            ->addColumn('system_name'     , $aDatabaseData['system_name'])
                            ->addColumn('system_name_slug', $aDatabaseData['system_name_slug'])
                            ->addColumn('enabled_from'    , $aDatabaseData['enabled_from'])
                            ->addColumn('enabled_to'      , $aDatabaseData['enabled_to'])
                         ->end()
                       ->insert(); 
    
                if($bSuccess) {
                    $this->aLastResult['result'] = true;
                    $this->aLastResult['msg']    = 'Inserted new Points System Episode';
                    
                    $this->iEpisodeID = $oGateway->lastInsertId();
                    
                } else {
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Unable to insert Points System Episode.';
                }
                
                
            } else {
                # There are no cal columns that need to be version so update
                # on the non key columns
                
                $bSuccess = $oGateway->updateQuery()
                            ->start()
                                ->addColumn('system_name'     , $aDatabaseData['system_name'])
                                ->addColumn('system_name_slug', $aDatabaseData['system_name_slug'])
                            ->where()
                                ->filterBySystem($aDatabaseData['system_id'])
                            ->end()
                            ->update();
                
                
                if($bSuccess) {
                    $this->aLastResult['result'] = true;
                    $this->aLastResult['msg']    = 'Updated All the Points System Episodes';
                    
                } else {
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Unable to update Points System Episods';
                }
                
            }
            
        } catch (Exception $e) {
            $this->getAppLogger()->error($e->getMessage());
        
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = $e->getMessage();
        }
        
        return $bSuccess;
    }
    
    public function remove(DateTime $oProcessDte)
    {
        if(false === empty($this->iEpisodeID) && false === empty($this->sSystemID)) {
            
            
            
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
                            ->whereEnabledAfterNow()
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
    
    public function updateAll(DateTime $oProcessDte)
    {
        
        
    }
    
    public function validate(DateTime $oProcessDte,$sOpt)
    {

    }
    
    
    
    protected function validateNewEpisode(DateTime $oProcessDte)
    {
    
        
    }
    
    protected function validateNewEntity(DateTime $oProcessDte)
    {
        
    }
    
    
    protected function validateUpdate(DateTime $oProcessDte)
    {
        
    }
    
    
}
/* End of File */

