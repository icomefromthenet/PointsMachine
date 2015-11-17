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
    
    
    
    protected function createNewEntity($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
       
            
       
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
        
        
       return $bSuccess;
    }
    
    protected function createNewEpisode($aDatabaseData)
    {
        $bSuccess          = false;
        $oGateway          = $this->getTableGateway();
        
        
        
        
        return $bSuccess;
    }
    
    
    protected function updateExistingEpisode($aDatabaseData)
    {
        
        
    }
    
    protected function checkTemportalFK($aDatabaseData)
    {
        $oGateway              = $this->getTableGateway();
        $oRuleChainGateway     = $oGateway->getGatewayCollection()->getGateway('pt_rule_chain');
        $oSystemZoneGateway    = $oGateway->getGatewayCollection()->getGateway('pt_system_zone');
        $oAdjGroupLimitGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oBuilder              = $oGateway->getEntityBuilder();
        
        # Check for Referential integrity in time 
        $bReqSystemZone = $oSystemZoneGateway->checkParentSystemRequired($this->sSystemID,$this->oEnabledTo);
        $bReqAdjGroup   =   $oAdjGroupLimitGateway->checkParentSystemRequired($this->sSystemID,$this->oEnabledTo);
        $bReqRuleChain  = $oAdjGroupLimitGateway->checkParentSystemRequired($this->sSystemID,$this->oEnabledTo);
         
        
        return array('SystemZone' => $bReqSystemZone,'AdjustmentGroup' => $bReqAdjGroup, 'RuleChain' => $bReqRuleChain);
    }
    
    
    protected function closeEpisode($aDatabaseData)
    {
        $oGateway              = $this->getTableGateway();
        
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
        
        return $bSuccess;
    }
    
    
    protected function validateNewEpisode(DateTime $oProcessDte)
    {
        
    }
   
    protected function validateNew(DateTime $oProcessDte)
    {
        
    }
    
    protected function validateUpdate(DateTime $oProcessDte)
    {
        
    }
          
    protected function validateRemove(DateTime $oProcessDte)
    {
        
    }
    
    
    
    public function updateAll(DateTime $oProcessDte)
    {
        
        
    }
    
   
    
    
}
/* End of File */

