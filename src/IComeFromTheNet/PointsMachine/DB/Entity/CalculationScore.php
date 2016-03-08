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
class CalculationScore {
    
 
    public $iScoringEventID;
    
    public $iScoreEP;
    
    public $iScoreGroupEP;
    
    public $fScoreBase;
    
    public $fScoreCalRaw;
    
    public $fScoreCalCapped;
    
    public $iScoreQuantity;
    
    
    
}
/* End of File */

