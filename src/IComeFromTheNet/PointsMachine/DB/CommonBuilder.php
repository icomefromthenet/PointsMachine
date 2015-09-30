<?php
namespace IComeFromTheNet\PointsMachine\DB;

use DBALGateway\Builder\AliasBuilder;
use DBALGateway\Table\AbstractTable;
use Psr\Log\LoggerInterface;

/**
  * A common builder that needed for common setters 
  * these dependecies are used by entities. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
abstract class CommonBuilder extends AliasBuilder 
{
    
    /**
     * @var DBALGateway\Table\AbstractTable
     */ 
    protected $oGateway;
    
    /**
     * @var Psr\Log\LoggerInterface
     */ 
    protected $oLogger;   
    
   
   public function setGateway(AbstractTable $oGateway)
   {
        $this->oGateway = $oGateway;
   }
   
   public function setLogger(LoggerInterface $oLogger)
   {
       $this->oLogger  = $oLogger;
   }
   
 
    
}
/* End of File */