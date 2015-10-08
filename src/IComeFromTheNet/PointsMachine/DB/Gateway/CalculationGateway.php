<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\CalculationQuery;

/**
 * Table gateway pt_scoring_transaction
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CalculationGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\CalculationQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new CalculationQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */