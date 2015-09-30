<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Driver;

/**
 * This provides tmp table managment procedures that are used by the
 * complier.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 0.1
 */ 
interface DriverInterface
{
    
    /**
     * Create the tmp table
     * 
     * @access public
     * @return boolean if the table was created
     * @param string    $sNewTableName
     */ 
    public function createTable($sNewTableName);
    
    
    /**
     * Truncate a temp table
     * 
     * @return void
     * @access public
     * @param string    $sTableName
     */ 
    public function truncateTable($sTableName);
    
    
    /**
     * Delete the tmp table
     * 
     * @access public
     * @return bool if table removed
     * @param string    $sTableName
     */ 
    public function removeTable($sTableName);
    
    
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
    public function cloneTable($sCloneTableName,$sNewTableName,$aColumns);
    
    
    /**
     * Return the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper();
    
}
/* End of Class */