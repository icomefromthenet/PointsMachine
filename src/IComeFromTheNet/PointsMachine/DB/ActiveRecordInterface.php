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
    
    public function saveEpisode(DateTime $oProcessDte);
    
    
    public function deleteEpisode(DateTime $oProcessDte);
    
    
    public function validate(DateTime $oProcessDte);
    
    
}
/* End of File */