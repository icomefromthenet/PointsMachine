<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\RuleChainMemberQuery;

/**
 * Table gateway pt_chain_member
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class RuleChainMemberGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\RuleChainMemberQuery
    */
    public function newQueryBuilder()
    {
        $this->head = new RuleChainMemberQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    
    /**
     * Check if a RuleChain has a 'current' relation to a ChainMember.
     * 
     * @param string    $sRuleChainId  The Entity ID
     * @return boolean true if a record found
     */ 
    public function checkParentChainRequired($sRuleChainId)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent(new DateTime('3000-01-01'))
                    ->filterByRuleChain($sRuleChainId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
}
/* End of Class */