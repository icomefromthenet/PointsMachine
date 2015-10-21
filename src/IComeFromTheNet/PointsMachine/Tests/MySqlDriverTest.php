<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Metadata\Table;

class MySqlDriverTest extends TestWithContainer
{
   
   
   public function getTableDefinition() 
   {
         $oTable = new Table('test_tmp_table');
       
        # set Mysql Options
        $oTable->addOption('temporary',true); 
        $oTable->addOption('engine','Memory');
        
        
        # pk of table
        $oTable->addColumn('slot_id','integer',array("unsigned" => true, 'autoincrement' => true, 'comment' => 'Calculation Slot surrogate key'));
        $oTable->setPrimaryKey(array('slot_id'));
        
        return $oTable; 
       
   }
   
   
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/ExampleFixture.php',
        ]);
    }
    
    
    public function testFetchedFromContainer()
    {
        $oContainer = $this->getContainer();
        $oTable     = $this->getTableDefinition(); 
        
        $oDriver = $oContainer->getTableDriver($oTable);
        
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oDriver);
       
        
    }
    
    public function testProperties()
    {
        $oContainer = $this->getContainer();
        $oTable     = $this->getTableDefinition(); 
        
        
        $oDriver = $oContainer->getTableDriver($oTable);
        
        $this->assertEquals($oContainer->getDatabaseAdaper(),$oDriver->getDatabaseAdaper());
        $this->assertInstanceOf('DBALGateway\Metadata\Table',$oDriver->getTableMeta());
        
    }
    
    
    
    public function testTableFunctions()
    {
        $oContainer = $this->getContainer();
        $oTable     = $this->getTableDefinition(); 
      
        $oDriver   = $oContainer->getTableDriver($oTable);
        $oDatabase = $oContainer->getDatabaseAdaper();
        $oDriver->createTable();
     
        $oDatabase->executeQuery("SELECT 1
        FROM test_tmp_table",array());
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