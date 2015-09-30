<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Pass;

use \DateTime;

/**
 * This complier used to combine a number of score rules.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 0.1
 */ 
interface CompilerInterface
{
    
    /**
     * Start the complier
     * 
     * @access public
     * @return void
     * @param ComplileResult    $oResult
     * @param DateTime          $oProcessingDate
     */ 
    public function execute(ComplileResult $oResult, DateTime $oProcessingDate);
    
    
    /**
     * Return the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper();
    

    /**
     * Add a pass to this complier, passes will be executed in 
     * the order they are added.
     * 
     * @param CompilerPassInterface $oPass  the pass to add.
     * @return void
     * 
     */ 
    public function addPass(CompilerPassInterface $oPass);
    
    /**
     * Return the complied result as collection.
     * 
     * @access public
     * @return Doctrine\Common\Collection
     */ 
    public function getResult();
    
    /**
     * Temp table that will hold the results at the start and the finish
     * though each pass may use their own temp tables
     * 
     * @access public
     * @return string the table name 
     */ 
    public function getResultTableName();
    
    
}
/* End of class */