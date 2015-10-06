<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\ScoringGroupQuery;

/**
 * Table gateway pt_rule_group
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoringGroupGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\ScoringGroupQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new ScoringGroupQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */