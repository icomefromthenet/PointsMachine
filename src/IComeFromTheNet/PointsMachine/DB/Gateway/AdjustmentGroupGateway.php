<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\AdjustmentGroupQuery;

/**
 * Table gateway pt_rule_group
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentGroupGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\AdjustmentGroupQuery
    */
    public function newQueryBuilder()
    {
        $this->head = new AdjustmentGroupQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
     /**
     * Check if a Adjustment Group with the given id is current
     * 
     * 
     * @param string    $sAdjGroupId  The Entity ID
     */ 
    public function checkAdjGroupIsCurrent($sAdjGroupId)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent(new DateTime('3000-01-01'))
                    ->filterByAdjustmentGroup($sAdjGroupId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
    
    
}
/* End of Class */