<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
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
    
    
    /**
     * Check if a AdjGroup has a 'current' relation to a AdjRule.
     * 
     * @param string    $sAdjGroupId  The Entity ID
     * @return boolean true if a record found
     */ 
    public function checkParentAdjGroupRequired($sAdjGroupId)
    {
        return (boolean) $this->newQueryBuilder()
                ->select(1)
                ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                ->filterByCurrent(new DateTime('3000-01-01'))
                ->filterByAdjustmentGroup($sAdjGroupId)
                ->end()
            ->fetchColumn(0);
    
        
    }
    
    /**
     * Check if a Adjustment Rule with the given id is current
     * 
     * 
     * @param string    $sAdjRukleId  The Entity ID
     * @param DateTime  $oNow       The Now data form the database
     */ 
    public function checkAdjRuleIsCurrent($sAdjRuleId)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent(new DateTime('3000-01-01'))
                    ->filterByAdjustmentRule($sAdjRuleId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
}
/* End of Class */