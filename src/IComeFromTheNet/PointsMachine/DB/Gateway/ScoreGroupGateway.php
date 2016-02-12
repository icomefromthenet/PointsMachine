<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\ScoreGroupQuery;

/**
 * Table gateway pt_score_group
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoreGroupGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\ScoreGroupQuery
    */
    public function newQueryBuilder()
    {
        $this->head = new ScoreGroupQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    
    /**
     * Check if a score group is 'current' and can be related to something else.
     * 
     * @param string    $sScoreGroupId  The Entity ID
     * @return boolean true if a record found
     */ 
    public function checkScoreGroupCurrent($sScoreGroupId)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent(new DateTime('3000-01-01'))
                    ->filterByScoreGroup($sScoreGroupId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
    public function checkScoreGroupIsCurrent($sScoreGroupId)
    {
        return $this->checkScoreGroupCurrent($sScoreGroupId);
    }
    
}
/* End of Class */