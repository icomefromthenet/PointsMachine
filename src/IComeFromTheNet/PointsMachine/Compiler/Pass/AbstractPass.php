<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Pass;

use DateTime;
use Doctrine\DBAL\Connection;
use DBALGateway\Table\GatewayProxyCollection;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;

/**
 * A common compiler pass, provides handlers for the properties
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
abstract class AbstractPass
{
   
    protected $oDatabase;
    protected $oGatewayCollecetion;
   
   
   public function __construct(Connection $oDatabase, GatewayProxyCollection $oCollection)
   {
        $this->oDatabase           = $oDatabase;
        $this->oGatewayCollecetion = $oCollection;
   }
   
   
    /**
     * Executes this pass.
     * 
     * @return boolean true if sucessful.
     */ 
    abstract public function execute(DateTime $oProcessingDate, CompileResult $oResult);

    
    /**
     * Return the database adapter
     *  
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper()
    {
        return $this->oDatabase;
    }
   
    
    
    /**
     * Gets the table gateway proxy collection
     * 
     * @return DBALGateway\Table\GatewayProxyCollection
     */ 
    public function getGatewayCollection()
    {
        return $this->oGatewayCollecetion;
    }
    
}
/* End of Pass */