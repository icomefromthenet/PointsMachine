<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Calculation Transactions
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class Calculation extends CommonEntity implements ActiveRecordInterface
{
    
    public $iProcessID;
    
    public $iAdjustmentRuleID;

    public $iAdjustmentGroupID;
    
    public $iScoreID;
    
    public $iScoreGroupID;
    
    public $iSystemID;
    
    public $iSystemZoneID;
    
    public $iEventType;
    
    public $iScoringEvent;
    
    public $fScoreBase;
    
    public $fScoreBalance;
    
    public $fScoreModifier;
    
    public $fScoreMultiplier;
    
    public $oCreatedDate;
    
    public $oProcessingDate;
    
    public $oOccuredDate;
    
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

