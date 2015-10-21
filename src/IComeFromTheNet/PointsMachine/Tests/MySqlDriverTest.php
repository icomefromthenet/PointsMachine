<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;


class MySqlDriverTest extends TestWithContainer
{
   
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/ExampleFixture.php',
        ]);
    }
    
    
    public function testFetchedFromContainer()
    {
        $oContainer = $this->getContainer();
        
        $oDriver = $oContainer->getTableDriver();
        
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oDriver);
       
        
    }
    
    public function testProperties()
    {
        $oContainer = $this->getContainer();
        
        $oDriver = $oContainer->getTableDriver();
        
        $this->assertEquals($oContainer->getDatabaseAdaper(),$oDriver->getDatabaseAdaper());
        $this->assertInstanceOf('DBALGateway\Metadata\Table',$oDriver->getTableMeta());
        
    }
    
    public function testTableNameUsed()
    {
        $oContainer = $this->getContainer();
        
        $oDriver = $oContainer->getTableDriver();
        
        $sTableName = $oDriver->getTableMeta()->getName();
        
        $this->assertEquals($oContainer['result_table_name'],$sTableName);
        
    }
    
    public function testTableFunctions()
    {
        $oContainer = $this->getContainer();
        $oDriver   = $oContainer->getTableDriver();
        $oDatabase = $oContainer->getDatabaseAdaper();
        $oDriver->createTable();
     
        $oDatabase->executeQuery("SELECT 1
        FROM ".$oContainer['result_table_name'],array());
        // if table not exists thrown an exception
        $this->assertTrue(true);
        
        $oDriver->truncateTable();
        
        $this->assertTrue(true);
        
        $oDriver->removeTable();
        
        $this->assertTrue(true);
        // not error out if remove worked
        $oDriver->createTable();
        
        $this->assertTrue(true);
        // cleanup
        $oDriver->removeTable();
    }
    
  
    
}
/* End of class */