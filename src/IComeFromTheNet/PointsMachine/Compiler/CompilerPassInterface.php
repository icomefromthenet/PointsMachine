<?php
namespace IComeFromTheNet\PointsMachine\Compiler;

use \DateTime;

/**
 * A single Process in this complier. 
 * 
 * All passes are run in consecutive fashion. 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 0.1
 */ 
interface CompilerPassInterface
{
    
    public function execute($sResultTableName, DateTime $oProcessingDate);
    
    
    public function getDatabaseAdaper();
    
    /**
     * 
     * 
     */ 
    public function getProcessingTableName();
    
    
    /**
     * Driver which abstracts the temp table managment
     * 
     * @return 
     */
    public function getTableOperationsDriver();
    
    
}
/* End of Class */
