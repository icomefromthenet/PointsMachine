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
    
    abstract protected function checkRemoveTemportalFK($aDatabaseData);
    
    abstract protected function checkCreateTemportalFK($aDatabaseData);
    
    abstract protected function closeEpisode($aDatabaseData);
    
    
    // -------------------------------------------------------------
    #  ActiveRecordInterface
    
    
    public function save()
    {
        $bSuccess          = false;
        $this->aLastResult = array( 'result' => '','msg' =>'');
        $oGateway          = $this->getTableGateway();
        $oBuilder          = $oGateway->getEntityBuilder();
        
        try {
        
            $oNow = $oGateway->getNow();
        
            if(true === empty($this->oEnabledFrom)) {
                $this->oEnabledFrom = $oNow;
            }
            
            if(true === empty($this->oEnabledTo)) {
                $this->oEnabledTo   = DateTime::createFromFormat('d-m-Y','01-01-3000');
            }
            
            
            $aDatabaseData     = $oBuilder->demolish($this);
            $bSuccess           = false;
           
            if(true === empty($this->iEpisodeID)) {
                
                // override the now as only create current entitie
                $this->oEnabledFrom = $oNow;
               
                if(true === $this->validateNew($aDatabaseData)) {
                    $aCheckAry  = $this->checkCreateTemportalFK($aDatabaseData);
                    
                    if(true === in_array(true,$aCheckAry)) {
                        $this->aLastResult['result'] = false;
                        $this->aLastResult['msg']    = 'Temporal Referential integrity violated check '.implode(',',array_keys(array_filter($aCheckAry,function($v){return $v;})));
                    } else {
                           $bSuccess = $this->createNewEntity($aDatabaseData);    
                    }
                }
                
                
            } elseif(false === empty($this->iEpisodeID) 
                     && $oNow->format('Y-m-d') !== $this->oEnabledFrom->format('Y-m-d')
                     && $this->oEnabledTo->format('Y-m-d')   === '3000-01-01') {
            
                // override the now as only store current changes
                $this->oEnabledFrom = $oNow;
             
                
                if(true === $this->validateNewEpisode($aDatabaseData)) {
                    $aCheckAry  = $this->checkCreateTemportalFK($aDatabaseData);
                    
                    if(true === in_array(true,$aCheckAry)) {
                        $this->aLastResult['result'] = false;
                        $this->aLastResult['msg']    = 'Temporal Referential integrity violated check '.implode(',',array_keys(array_filter($aCheckAry,function($v){return $v;})));
                    } else {
                        $bSuccess =  $this->createNewEpisode($aDatabaseData);
                    }
                }
            
                
            } elseif(false === empty($this->iEpisodeID) 
                    && $this->oEnabledFrom->format('Y-m-d') === $oNow->format('Y-m-d')  
                    && $this->oEnabledTo->format('Y-m-d')   === '3000-01-01') {
                 
                if(true === $this->validateUpdate($aDatabaseData)) {
                    $aCheckAry  = $this->checkCreateTemportalFK($aDatabaseData);
                    
                    if(true === in_array(true,$aCheckAry)) {
                        $this->aLastResult['result'] = false;
                        $this->aLastResult['msg']    = 'Temporal Referential integrity violated check '.implode(',',array_keys(array_filter($aCheckAry,function($v){return $v;})));
                    } else {
                        $bSuccess =  $this->updateExistingEpisode($aDatabaseData);
                    }
                }
                  
                
            } else {
                
                $this->aLastResult['result'] = false;
                $this->aLastResult['msg'] = 'Unable to decide which operation to use';
            }
            
            
            
        } catch (Exception $e) {
           
            $this->getAppLogger()->error($e->getMessage());
        
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = $e->getMessage();
            throw $e; 
        }
        
        
        return $this->aLastResult['result'];
    }
    
     // -------------------------------------------------------------
    
    public function remove()
    {
        $oGateway              = $this->getTableGateway();
        $oBuilder              = $oGateway->getEntityBuilder();
        $this->aLastResult     = array( 'result' => false,'msg' =>'');
        
        
        if(false === empty($this->iEpisodeID)) {
           
            try {
           
                $this->oEnabledTo   = $oGateway->getNow();
                $aDatabaseData      = $oBuilder->demolish($this);   
                $bSuccess           = false;
                
                # Check for Referential integrity in time 
                
                $aCheckAry          = $this->checkRemoveTemportalFK($aDatabaseData);
                
                if(true === in_array(true,$aCheckAry)) {
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Temporal Referential integrity violated check '.implode(',',array_keys(array_filter($aCheckAry,function($v){return $v;})));
                    
                } else {
                    
                    if(true === $this->validateRemove($aDatabaseData)) {
                        $this->closeEpisode($aDatabaseData);
                    }
                    
                }
                
                
            
            } catch (Exception $e) {
                
                $this->getAppLogger()->error($e->getMessage());
                $this->aLastResult['msg'] = $e->getMessage();
                $this->aLastResult['result'] = false;
                
                throw $e;
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
    
    abstract protected function validateNewEpisode();
   
    
   
}
/* End of File */
