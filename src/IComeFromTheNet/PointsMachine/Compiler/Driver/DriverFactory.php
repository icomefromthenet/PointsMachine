<?php 
namespace IComeFromTheNet\PointsMachine\Compiler\Driver;


use Doctrine\DBAL\Driver;

/**
 *  Maps Doctrine Database Plaftorms to our table DDL Driver
 * 
 *  @since 1.0
 *  @author Lewis Dyer <getintouch@icomefromthenet.com.au>
 */ 
class DriverFactory
{
    
    /**
     * @array(driver_name => interal_driver)
     */ 
    protected $aDoctrinePlaforms = array(
       'pdo_mysql'  => 'IComeFromTheNet\PointsMachine\Compiler\Driver\MYSQLDriver',
    );
    
    /**
     * Fetch our internal driver for that used in the doctrine DBAL
     * connection
     * 
     * @return string the classname
     */ 
    public function getDriverClass(Driver $oDoctrineDriver)
    {
        $sName = strtolower($oDoctrineDriver->getName());
        
        return $this->aDoctrinePlaforms[$sName];
    }
    
}
/* End of Class */