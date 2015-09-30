<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Driver;

use Doctrine\DBAL\Connection;


class MYSQLDriver implements DriverInterface
{
    
    /**
     * @var Doctrine\DBAL\Connection
    */ 
    protected $oAdapter;
    
    
    
    public function __construct(Connection $oAdapter)
    {
        $this->oAdapter = $oAdapter;
        
    }
    
    
    /**
     * Create the tmp table
     * 
     * @access public
     * @return boolean if the table was created
     * @param string    $sNewTableName
     */ 
    public function createTable($sNewTableName)
    {
        
    }
    
    
    /**
     * Truncate a temp table
     * 
     * @return void
     * @access public
     * @param string    $sTableName
     */ 
    public function truncateTable($sTableName)
    {
        
    }
    
    
    /**
     * Delete the tmp table
     * 
     * @access public
     * @return bool if table removed
     * @param string    $sTableName
     */ 
    public function removeTable($sTableName)
    {
        
    }
    
    
    /**
     * Copy the select columns from existing table into a new 
     * table.
     * 
     * Assume the dest table exists.
     * 
     * @access public
     * @return integer number of affected rows
     * @param string    $sCloneTableName
     * @param string    $sNewTableName
     * @param array     $aColumns
     */ 
    public function cloneTable($sCloneTableName,$sNewTableName,$aColumns)
    {
        
    }
    
    
    /**
     * Return the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper()
    {
        return $oAdapter;
    }
    
    
    
    
}
/* End of Class */