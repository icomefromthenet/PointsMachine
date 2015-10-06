<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the score rule groups
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoringGroup extends CommonEntity implements ActiveRecordInterface
{
    
    public $iEpisodeID;
    
    public $sScoringGroupID;
    
    public $sGroupName;
    
    public $sGroupNameSlug;

    public $fMaxMultiplier;
    
    public $fMinMultiplier;
    
    public $fMaxModifier;
    
    public $fMinModifier;
    
    public $iMaxCount;
    
    public $iOrderMethod;
    
    public $bIsMandatory;
    
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

