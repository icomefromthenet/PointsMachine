<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\RuleChainQuery;

/**
 * Table gateway pt_rule_chain
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class RuleChainGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\RuleChainQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new RuleChainQuery($this->adapter,$this);
    }
    
    /**
     * Check if any Rule Chains have a requirement on a parent 
     * being active after the given date.
     * 
     * NOW should be date fetch from the database.
     * 
     * @param string    $sSystemId  The Entity ID
     * @param DateTime  $oNow       The Now data form the database
     */ 
    public function checkParentSystemRequired($sSystemId, DateTime $oNow)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByDisabledAfter($oNow)
                    ->filterBySystem($sSystemId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
}
/* End of Class */