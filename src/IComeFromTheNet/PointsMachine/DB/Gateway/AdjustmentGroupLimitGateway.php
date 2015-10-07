<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\AdjustmentGroupLimitQuery;

/**
 * Table gateway pt_rule_group_limits
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentGroupLimitGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\AdjustmentGroupLimitQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new AdjustmentGroupLimitQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */