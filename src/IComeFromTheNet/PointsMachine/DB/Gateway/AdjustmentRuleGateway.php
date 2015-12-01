<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\AdjustmentRuleQuery;

/**
 * Table gateway pt_rule
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentRuleGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\AdjustmentRuleQuery
    */
    public function newQueryBuilder()
    {
        $this->head = new AdjustmentRuleQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    
    
}
/* End of Class */