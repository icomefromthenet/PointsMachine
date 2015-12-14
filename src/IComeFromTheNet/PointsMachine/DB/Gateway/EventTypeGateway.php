<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
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
    
    
     /**
     * Check if a event type with the given id is current
     * 
     * NOW should be date fetch from the database.
     * 
     * @param string    $sEventTypeId  The Entity ID
     * @param DateTime  $oNow       The Now data form the database
     */ 
    public function checkEventTypeIsCurrent($sEventTypeId, DateTime $oNow)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent($oNow)
                    ->filterByEventType($sEventTypeId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
    
}
/* End of Class */