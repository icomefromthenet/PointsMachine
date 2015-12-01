<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\EventTypeQuery;

/**
 * Table gateway pt_event_type
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class EventTypeGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\EventTypeQuery
    */
    public function newQueryBuilder()
    {
        $this->head = new EventTypeQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    
    
}
/* End of Class */