<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\PointSystemZoneQuery;

/**
 * Table gateway pt_system_zone
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class PointSystemZoneGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\PointSystemZoneQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new PointSystemZoneQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */