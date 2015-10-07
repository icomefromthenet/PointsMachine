<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\AdjustmentZoneQuery;

/**
 * Table gateway pt_rule_sys_zone
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentZoneGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\AdjustmentZoneQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new AdjustmentZoneQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */