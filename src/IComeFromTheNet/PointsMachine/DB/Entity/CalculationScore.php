<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Calculation Transactions Scores 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CalculationScore extends CommonEntity implements ActiveRecordInterface
{
    
 
    public $iScoringEventID;
    
    public $iScoreEP;
    
    public $iScoreGroupEP;
    
    public $fScoreBase;
    
    public $fScoreCalRaw;
    
    public $fScoreCalRounded;
    
    public $fScoreCalCapped;
    
    
    
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

