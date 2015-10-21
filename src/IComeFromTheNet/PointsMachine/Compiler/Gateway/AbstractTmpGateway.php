<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Gateway;

use IComeFromTheNet\PointsMachine\DB\CommonTable;
use IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface;

/**
 * Common gateway for tmp tables includes properties for the table maker
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
abstract class AbstractTmpGateway extends CommonTable
{
    
    /**
     * @var IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface
     */ 
    protected $oTableDiver;
    
    
    /**
     * Sets the table maker driver
     * 
     * @param DriverInterface   $oDriver
     */ 
    public function setTableMaker(DriverInterface $oDriver)
    {
        $this->oTableDriver = $oDriver;
    }
    
    /**
     * Returns the table maker driver
     * 
     * @return DriverInterface
     */ 
    public function getTableMaker()
    {
        return $this->oTableDriver;
    }
    
    
}
/* End of class */