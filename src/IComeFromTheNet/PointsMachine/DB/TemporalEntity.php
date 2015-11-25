<?php 
namespace IComeFromTheNet\PointsMachine\DB;

use DateTime;
use DBALGateway\Table\AbstractTable;
use Psr\Log\LoggerInterface;

/**
 * Entity for the points system
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
abstract class TemporalEntity  extends CommonEntity
{
   
    
    // -------------------------------------------------------------
    #  Temporal Methods
    
    abstract protected function createNewEntity($aDatabaseData);
    
    abstract protected function createNewEpisode($aDatabaseData);
    
    abstract protected function updateExistingEpisode($aDatabaseData); 
    
    abstract protected function checkTemportalFK($aDatabaseData);
    
    abstract protected function closeEpisode($aDatabaseData);
    
    
    // -------------------------------------------------------------
    #  ActiveRecordInterface
    
    
    public function save()
    {
        $bSuccess          = false;
        $this->aLastResult = array( 'result' => '','msg' =>'');
        $oGateway          = $this->getTableGateway();
        $oBuilder          = $oGateway->getEntityBuilder();
        
        $oGateway->getAdapter()->beginTransaction();
              
        try {
        
            $oNow = $oGateway->getNow();
        
            if(true === empty($this->oEnabledFrom)) {
                $this->oEnabledFrom = $oNow;
            }
            
            $this->oEnabledTo   = DateTime::createFromFormat('d-m-Y','01-01-3000');
            $aDatabaseData     = $oBuilder->demolish($this);
            $bSuccess           = false;
            
           
            
            if(true === empty($this->iEpisodeID)) {
                
                // override the now as only create current entitie
                $this->oEnabledFrom = $oNow;
               
                if(true === $this->validateNew($aDatabaseData)) {
                    $bSuccess = $this->createNewEntity($aDatabaseData);
                }
                
                
            } elseif(false === empty($this->iEpisodeID) && $oNow->format('Y-m-d') !== $this->oEnabledFrom->format('Y-m-d')) {
                
                // override the now as only store current changes
                $this->oEnabledFrom = $oNow;
                
               
                
                if(true === $this->validateNewEpisode($aDatabaseData)) {
                  $bSuccess =  $this->createNewEpisode($aDatabaseData);  
                }
            
                
            } elseif(false === empty($this->iEpisodeID) && $oNow->format('Y-m-d') === $this->oEnabledFrom->format('Y-m-d')) {
                
                if(true === $this->validateUpdate($aDatabaseData)) {
                  $bSuccess =  $this->updateExistingEpisode($aDatabaseData);
                }
                  
                
            } else {
                
                $this->aLastResult['result'] = false;
                $this->aLastResult['msg'] = 'Unable to decide which operation to use';
            }
            
            if($bSuccess) {
                $oGateway->getAdapter()->commit();
            }
            
        } catch (Exception $e) {
            $oGateway->getAdapter()->rollback();
            $this->getAppLogger()->error($e->getMessage());
        
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = $e->getMessage();
            
        }
        
        
        return $this->aLastResult['result'];
    }
    
     // -------------------------------------------------------------
    
    public function remove()
    {
        $oGateway              = $this->getTableGateway();
        $oBuilder              = $oGateway->getEntityBuilder();
        $this->aLastResult     = array( 'result' => '','msg' =>'');
        
        
        if(false === empty($this->iEpisodeID)) {
           
            $oGateway->getAdapter()->beginTransaction();
           
            try {
           
                $this->oEnabledTo   = $oGateway->getNow();
                $aDatabaseData      = $oBuilder->demolish($this);   
                $bSuccess           = false;
                
                # Check for Referential integrity in time 
                
                $aCheckAry          = $this->checkTemportalFK($aDatabaseData);
                
                if(true === in_array(true,$aCheckAry)) {
                    $oGateway->getAdapter()->rollback();
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Temporal Referential integrity violated check '.implode(',',array_keys(array_filter($aCheckAry,function($v){return $v;})));
                    
                } else {
                    
                    if(true === $this->validateRemove($aDatabaseData)) {
                        $bSuccess = $this->closeEpisode($aDatabaseData);
                        $oGateway->getAdapter()->commit();
                    }
                    
                }
                
                
            
            } catch (Exception $e) {
                $oGateway->getAdapter()->rollback();
                $this->getAppLogger()->error($e->getMessage());
                $this->aLastResult['msg'] = $e->getMessage();
            }
            
        }
        else {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = 'Require and Episode Id';
        }
        
        
        return $this->aLastResult['result'];
    }
    
   
    
    
    //-----------------------------------------------------------------
    # Extra Validator Helpers
    
    abstract protected function validateNewEpisode($aDatabaseData);
   
    
   
}
/* End of File */
