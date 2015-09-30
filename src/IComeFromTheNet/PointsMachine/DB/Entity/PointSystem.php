<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;

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
    
                if($success) {
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
                       
                 if($success) {
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
        
        
        
    }
    
    public function validate(DateTime $oProcessDte)
    {
        
    }
    
}
/* End of File */

