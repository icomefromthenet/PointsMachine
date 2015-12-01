<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\DB\Query\ScoreQuery;

/**
 * Table gateway pt_score
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoreGateway extends CommonTable
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\DB\Query\ScoreQuery
    */
    public function newQueryBuilder()
    {
        $this->head = new ScoreQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
        return $this->head;
    }
    
    /**
     * Check if a score group has a 'current' relation to a score.
     * 
     * @param string    $sScoreGroupId  The Entity ID
     * @return boolean true if a record found
     */ 
    public function checkParentScoreGroupRequired($sScoreGroupId)
    {
        
        return (boolean) $this->newQueryBuilder()
                    ->select(1)
                    ->from($this->getMetaData()->getName(),$this->getTableQueryAlias())
                    ->filterByCurrent(new DateTime('3000-01-01'))
                    ->filterByScoreGroup($sScoreGroupId)
                    ->end()
                ->fetchColumn(0);
        
    }
    
}
/* End of Class */