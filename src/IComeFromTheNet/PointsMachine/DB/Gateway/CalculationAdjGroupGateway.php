<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\CalculationQuery;


/**
 * Table gateway pt_transaction_group
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CalculationAdjGroupGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\CalculationQuery
    */
    public function newQueryBuilder()
    {
        $this->head = new CalculationQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
        
    }
    
    
    
}
/* End of Class */