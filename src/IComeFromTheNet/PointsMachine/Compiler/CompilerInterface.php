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
    public function execute(DateTime $oProcessingDate, ComplileResult $oResult);
    
    
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
     * Return the results saved in the transaction tables
     * 
     * @access public
     * @return array
     */ 
    public function getResult();
    
    
    /**
     * Fetch the assigned logger
     * 
     * @return LoggerInterface
     */ 
    public function getLogger();
    
}
/* End of class */