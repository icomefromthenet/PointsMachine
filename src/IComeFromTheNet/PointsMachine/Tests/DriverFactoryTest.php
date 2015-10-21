<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use IComeFromTheNet\PointsMachine\Compiler\Driver\DriverFactory;


class DriverFactoryTest extends TestWithContainer
{
   
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/ExampleFixture.php',
        ]);
    }
    
    
    public function testDriverFetchMysql()
    {
        $oContainer = $this->getContainer();
        $oDatabase  = $oContainer->getDatabaseAdaper();
        $oFactory   = new DriverFactory();
        
        $this->assertEquals('IComeFromTheNet\PointsMachine\Compiler\Driver\MYSQLDriver',$oFactory->getDriverClass($oDatabase->getDriver()));
        
    }
    
  
    
}
/* End of class */