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
     
     */ 
    public function createTable();
    
    
    /**
     * Truncate a temp table
     * 
     * @return void
     * @access public
     
     */ 
    public function truncateTable();
    
    
    /**
     * Delete the tmp table
     * 
     * @access public
     * @return bool if table removed
     
     */ 
    public function removeTable();
    
    
    
    /**
     * Return the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper();
    
    /**
     * Return the table schema object
     * 
     * @return DBALGateway\Metadata\Table
     */ 
    public function getTableMeta();
    
    
}
/* End of Class */