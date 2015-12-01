<?php
namespace IComeFromTheNet\PointsMachine\DB;


/**
 * Defines an active record interface for entity objects
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
interface ActiveRecordInterface 
{
    
    public function save();
    
    
    public function remove();
    
    
    
}
/* End of File */