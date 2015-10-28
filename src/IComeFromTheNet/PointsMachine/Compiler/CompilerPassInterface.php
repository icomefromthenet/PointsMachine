<?php
namespace IComeFromTheNet\PointsMachine\Compiler;

use \DateTime;

/**
 * A single Process in this complier. 
 * 
 * All passes are run in consecutive fashion. 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
interface CompilerPassInterface
{
    
    /**
     * Executes this pass.
     * 
     * @return boolean true if sucessful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult);
    
    
    /**
     * Return the database adapter
     *  
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper();
   
  
    
    /**
     * Gets the table gateway proxy collection
     * 
     * @return DBALGateway\Table\GatewayProxyCollection
     */ 
    public function getGatewayCollection();
    
}
/* End of Class */
