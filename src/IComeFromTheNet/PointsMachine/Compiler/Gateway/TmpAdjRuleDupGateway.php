<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Gateway;

/**
 * This is a Gateway for the Rules Dupe Tmp Table
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TmpAdjRuleDupGateway extends AbstractTmpGateway
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