<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

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
        return $this->head = new ScoreGroupQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */