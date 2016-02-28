<?php
namespace IComeFromTheNet\PointsMachine\Compiler;

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
    public function execute(DateTime $oProcessingDate, CompileResult $oResult);
    
    
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
     * Return the result stored in the transaction tables.
     * 
     * @access public
     * @return array
     * @param integer The Event Instance To find
     */ 
    public function getResult($iEventId);
    
    /**
     * Fetch the assigned logger
     * 
     * @return LoggerInterface
     */ 
    public function getLogger();
    
}
/* End of class */