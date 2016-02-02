<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the Calculation Transactions Header 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CalculationEvent 
{
    
 
    public $iScoringEventID;
    
    public $iSystemEP;
    
    public $iSystemZoneEP;
    
    public $iEventTypeEP;
    
    public $oCreatedDate;
    
    public $oProcessingDate;
    
    public $oOccuredDate;
    
    
    
}
/* End of File */

