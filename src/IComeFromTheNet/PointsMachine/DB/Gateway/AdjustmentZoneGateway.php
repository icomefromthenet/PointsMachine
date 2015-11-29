<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
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
        $this->head = new AdjustmentZoneQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    
     /**
     * Check if a system zone has a current relation to a adjustment rule
     *
     * @param string    $sSystemZoneId  The System Zone Entity ID
     * @return boolean true if a record exists
     */ 
    public function checkZoneIsCurrent($sSystemZoneId)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent(new DateTime('3000-01-01'))
                    ->filterBySystemZone($sSystemZoneId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
    
}
/* End of Class */