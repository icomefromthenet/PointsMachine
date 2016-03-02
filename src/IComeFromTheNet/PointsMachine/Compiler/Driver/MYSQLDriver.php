<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use DBALGateway\Metadata\Table;

class MYSQLDriver implements DriverInterface
{
    
    /**
     * @var Doctrine\DBAL\Connection
    */ 
    protected $oAdapter;
    
    /**
     * @varDBALGateway\Metadata\Table
     */ 
    protected $oTable;
    
    
    
    public function __construct(Connection $oAdapter, Table $oTable)
    {
        $this->oAdapter = $oAdapter;
        $this->oTable   = $oTable;
       
    }
    
    
    /**
     * Create the tmp table
     * 
     * @access public
     * @return boolean if the table was created
     */ 
    public function createTable()
    {
        $oDatabase     = $this->getDatabaseAdaper();
        $sNewTableName = $this->getTableMeta()->getName();
        $oTable        = $this->getTableMeta();
        try {
            
            $aSql =  $oDatabase->getDatabasePlatform()
                                ->getCreateTableSQL($oTable);
            
            
            foreach($aSql as $sSql) {
                $oDatabase->executeUpdate($sSql);    
            }
            
            
        } catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
        }
        
    }
    
    
    /**
     * Truncate a temp table
     * 
     * @return void
     * @access public
     */ 
    public function truncateTable()
    {
        $oDatabase     = $this->getDatabaseAdaper();
        $sTableName    = $this->getTableMeta()->getName();
        
        
        $sSql  = "TRUNCATE $sTableName";
        
        try {
            
            $oDatabase->executeUpdate($sSql);
            
        } catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
        }
        
        
    }
    
    
    /**
     * Delete the tmp table
     * 
     * @access public
     * @return bool if table removed
     */ 
    public function removeTable()
    {
        $oDatabase     = $this->getDatabaseAdaper();
        $sTableName    = $this->getTableMeta()->getName();
    
    
        $sSql = "DROP TEMPORARY TABLE IF EXISTS $sTableName";
        
        try {
            
            $oDatabase->executeUpdate($sSql);
            
        } catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
        }
    }
    
    
   
    
    /**
     * Return the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper()
    {
        return $this->oAdapter;
    }
    
    
    /**
     * Return the table schema object
     * 
     * @return DBALGateway\Metadata\Table
     */ 
    public function getTableMeta()
    {
        return $this->oTable;
    }
    
    
    
}
/* End of Class */