<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
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
        $this->head = new PointSystemZoneQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    /**
     * Check if a system has a 'current' relation to a zone.
     * 
     * @param string    $sSystemId  The Entity ID
     * @return boolean true if a record found
     */ 
    public function checkParentSystemRequired($sSystemId)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent(new DateTime('3000-01-01'))
                    ->filterBySystem($sSystemId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
    
}
/* End of Class */