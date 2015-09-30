<?php
namespace IComeFromTheNet\PointsMachine;

use DateTime;
use Pimple;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use DBALGateway\Table\GatewayProxyCollection;
use DBALGateway\Metadata\Schema;

use IComeFromTheNet\PointsMachine\DB\Builder\PointSystemBuilder;
use IComeFromTheNet\PointsMachine\DB\Gateway\PointSystemGateway;


class PointsMachineContainer extends Pimple
{
    
    /**
     * Class constructor
     * 
     * @param Symfony\Component\EventDispatcher\EventDispatcherInterface
     * @param Doctrine\DBAL\Connection $oAdapter
     * @param Psr\Log\LoggerInterface $oLogger
     */
    public function __construct(EventDispatcherInterface $oDispatcher, Connection $oAdapter, LoggerInterface $oLogger)
    {
        $this['database'] = $oAdapter;
        $this['logger'] = $oLogger;
        $this['event'] = $oDispatcher;
    }
    
    
    /**
     * Returns the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper()
    {
        return $this['database'];
    }
    
    
    
    /**
     * Returns the Applogger
     * 
     * @return Psr\Log\LoggerInterface
     */ 
    public function getAppLogger()
    {
        return $this['logger'];
    }
    
    /**
     * Returns the event dispatcher
     * 
     * @return Symfony\Component\EventDispatcher\EventDispatcherInterface
     */ 
    public function getEventDispatcher()
    {
        return $this['event'];
    }
    
    /**
     * Return the Gateway Collection
     * 
     * @return DBALGateway\Table\GatewayProxyCollection
     */ 
    public function getGatewayCollection()
    {
        return $this['gateway_collection'];
    }
    
    
    public function boot(DateTime $oProcessingDate, $aTableMap = null)
    {
        $this['processing_date'] = $oProcessingDate;
        
        if(null === $aTableMap) {
            $aTableMap = array(
              'pt_system' => 'pt_system'  
                
            );
        }
        $this['table_map']       = $aTableMap;
        
        #
        # Boostrap the table Gateways
        #
        $c           = $this;
        $oSchema     = new Schema();
        $oGatewayCol = new GatewayProxyCollection($oSchema);
        
        $oGatewayCol->addGateway('pt_system',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_system'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('system_id','guid',array());
            $table->addColumn('system_name','string',array("length" => 100));
            $table->addColumn('system_name_slug','string',array("length" => 100));
            $table->addColumn('enabled_from','datetime',array());
            $table->addColumn('enabled_to','datetime',array());
        
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('system_id','enabled_from'),'pt_system_uiq1');
           
            $oBuilder = new PointSystemBuilder();
            $oGateway = new PointSystemGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('s');
            
            return $oGateway;
        });
        
        
        
        $this['gateway_collection'] = $oGatewayCol;    
        
    }
    
}
/* End of Class */