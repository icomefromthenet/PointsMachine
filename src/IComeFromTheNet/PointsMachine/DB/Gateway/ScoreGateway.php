<?php
namespace IComeFromTheNet\PointsMachine\DB\Gateway;

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
        return $this->head = new ScoreQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */