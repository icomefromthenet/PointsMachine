<?php
namespace IComeFromTheNet\PointsMachine\DB;

use DateTime;

/**
 * Defines an active record interface for entity objects
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
interface ActiveRecordInterface 
{
    
    public function save(DateTime $oProcessDte);
    
    
    public function remove(DateTime $oProcessDte);
    
    public function updateAll(DateTime $oProcessDte);
    
    
    public function validate(DateTime $oProcessDte, $sOpt);
    
    
}
/* End of File */