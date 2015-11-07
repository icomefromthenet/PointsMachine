<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Gateway;

/**
 * This is a Gateway for the result detail Tmp Table.
 * 
 * This table only have 1 row.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TmpResultDetailGateway extends AbstractTmpGateway
{
    /**
    * Create a new instance of the querybuilder
    *
    * @access public
    * @return IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpTableQuery
    */
    public function newQueryBuilder()
    {
        return $this->head = new TmpTableQuery($this->adapter,$this);
    }
    
    
}
/* End of Class */