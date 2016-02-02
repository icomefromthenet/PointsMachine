<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Calculation Transactions Adjustment Rules
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CalculationAdjRule 
{
    
 
    public $iScoringEventID;
    
    public $iScoreEP;
    
    public $iAdjustmentRuleEP;
    
    public $fScoreModifier;
    
    public $fScoreMultiplier;
    
    public $iOrderSeq;
   
    
}
/* End of File */

