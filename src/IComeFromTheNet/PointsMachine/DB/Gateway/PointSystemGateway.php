<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\PointSystemQuery;

/**
 * Table gateway pt_system
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class PointSystemGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\PointSystemQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new PointSystemQuery($this->adapter,$this);
    }
    
    
}
/* End of Class */