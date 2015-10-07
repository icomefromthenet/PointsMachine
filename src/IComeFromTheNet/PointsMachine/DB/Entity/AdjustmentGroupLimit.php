<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Used to limit AdjustmentGroup to a ScoreGroup
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentGroupLimit extends CommonEntity implements ActiveRecordInterface
{
    
    public $sAdjustmentGroupID;
    
    public $sScoreGroupID;
    
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

