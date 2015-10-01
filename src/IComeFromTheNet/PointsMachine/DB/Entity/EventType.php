<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the event types
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class EventType extends CommonEntity implements ActiveRecordInterface
{
    
    public $iEpisodeID;
    
    public $sEventTypeID;
    
    public $sEventName;
    
    public $sEventNameSlug;
    
    public $fCapValue;
    
    public $iRoundingOption;
    
    public $oEnabledFrom;
    
    public $oEnabledTo;
    
    
    
    public function saveEpisode(DateTime $oProcessDte)
    {
       
    }
    
    public function deleteEpisode(DateTime $oProcessDte)
    {
       
    }
    
    public function validate(DateTime $oProcessDte)
    {
         
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

