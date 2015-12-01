<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
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
        $this->head = new AdjustmentGroupLimitQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    
    /**
     * Check if a System has a 'current' relation to a Adjustment Group
     * 
     * @param string    $sSystemId  The Entity ID
     * @return boolean true if a record is found
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