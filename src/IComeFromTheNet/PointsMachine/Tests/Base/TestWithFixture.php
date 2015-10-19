<?php
namespace IComeFromTheNet\PointsMachine\Tests\Base;

use \PDO;
use \PHPUnit_Extensions_Database_Operation_Composite;
use \PHPUnit_Extensions_Database_TestCase;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\DBOperationSetEnv;


class TestWithFixture extends PHPUnit_Extensions_Database_TestCase
{
    
   
    // ----------------------------------------------------------------------------
    
    /**
    * @var PDO only instantiate pdo once for test clean-up/fixture load
    * @access private
    */
    static private $pdo = null;
    /**
    * @var \Doctrine\DBAL\Connection
    * @access private
    */
    static private $doctrineConnection;
    
    /**
    * @var PHPUnit_Extensions_Database_DB_IDatabaseConnection only instantiate once per test
    * @access private
    */
    private $conn = null;
    
    /**
     * Holder to common fixtures in a singl TestCase
     */ 
    protected $aFixtures = array();
    
    
    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO($GLOBALS['DEMO_DATABASE_DSN'], $GLOBALS['DEMO_DATABASE_USER'], $GLOBALS['DEMO_DATABASE_PASSWORD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DEMO_DATABASE_SCHEMA']);
        }
        return $this->conn;
    }
    
    protected function getSetUpOperation()
    {
        return new PHPUnit_Extensions_Database_Operation_Composite(array(
            new DBOperationSetEnv('foreign_key_checks',0),
            parent::getSetUpOperation(),
            new DBOperationSetEnv('foreign_key_checks',1),
        ));
    }
    
    
    public function getDataSet($fixtures = array()) {
    
        if (empty($fixtures)) {
            $fixtures = $this->aFixtures;
        }
        
        $fixturePath = realpath((__DIR__) . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR . 'fixture');
        
        $aPaths = array();
        
        foreach ($fixtures as $fixture) {
            $aPaths[] =  $fixturePath . DIRECTORY_SEPARATOR . "$fixture";
        }
    
        return new ArrayDataSet($aPaths);
    }
    
    
    /**
    * Gets a db connection to the test database
    *
    * @access protected
    * @return \Doctrine\DBAL\Connection
    */
    protected function getDoctrineConnection()
    {
        if(self::$doctrineConnection === null) {
        
            $config = new \Doctrine\DBAL\Configuration();
            
            $connectionParams = array(
                'dbname' => $GLOBALS['DEMO_DATABASE_SCHEMA'],
                'user' => $GLOBALS['DEMO_DATABASE_USER'],
                'password' => $GLOBALS['DEMO_DATABASE_PASSWORD'],
                'host' => $GLOBALS['DEMO_DATABASE_HOST'],
                'driver' => $GLOBALS['DEMO_DATABASE_TYPE'],
                'port'   => $GLOBALS['DEMO_DATABASE_PORT'],
            );
        
           self::$doctrineConnection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        }
        
        return self::$doctrineConnection;
        
    }
    
    /**
     * Used to load a new dataset in method and have it applied to database
     * 
     * @return void
     */ 
    public function loadDataSet($dataSet) {
        // set the new dataset
        $this->getDatabaseTester()->setDataSet($dataSet);
        // call setUp which adds the rows
        $this->getDatabaseTester()->onSetUp();
    }
        
   
}
/* End of File */