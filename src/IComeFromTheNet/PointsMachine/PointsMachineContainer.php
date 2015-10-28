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

use IComeFromTheNet\PointsMachine\DB\Builder\PointSystemZoneBuilder;
use IComeFromTheNet\PointsMachine\DB\Gateway\PointSystemZoneGateway;

use IComeFromTheNet\PointsMachine\DB\Gateway\EventTypeGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\EventTypeBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\ScoringEventGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\ScoringEventBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\ScoreGroupGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\ScoreGroupBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\ScoreGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\ScoreBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentGroupGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\AdjustmentGroupBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentGroupLimitGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\AdjustmentGroupLimitBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentRuleGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\AdjustmentRuleBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentZoneGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\AdjustmentZoneBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\CalculationGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\CalculationBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\RuleChainGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\RuleChainBuilder;

use IComeFromTheNet\PointsMachine\DB\Gateway\RuleChainMemberGateway;
use IComeFromTheNet\PointsMachine\DB\Builder\RuleChainMemberBuilder;

use IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface;
use IComeFromTheNet\PointsMachine\Compiler\Driver\MYSQLDriver;
use IComeFromTheNet\PointsMachine\Compiler\Driver\DriverFactory;

use IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpAdjRuleGateway;
use IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpResultsGateway;
use IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpScoresGateway;

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
    
    /**
     * Return the Table DDL driver
     * 
     * @return IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface
     */ 
    public function getTableDriver($oTable)
    {
        $oDatabase = $this->getDatabaseAdaper();
        $oFactory  = $this->getTableFactory();
        $sClass    = $oFactory->getDriverClass($oDatabase->getDriver()); 
           
        return new $sClass($oDatabase,$oTable);
      
    }
    
    /**
     * Return the DDL Table factory 
     * 
     * @return IComeFromTheNet\PointsMachine\Compiler\Driver\DriverFactory
     */ 
    public function getTableFactory()
    {
        return $this['table_factory'];
    }
    
    /**
     * Return the map of internal table names
     * to actual table names
     *  
     * @return array[internal => actual]
     */ 
    public function getTableMap()
    {
        return $this['table_map'];
    }
    
    public function boot(DateTime $oProcessingDate, $aTableMap = null)
    {
        $this['processing_date'] = $oProcessingDate;
        
        if(null === $aTableMap) {
            $aTableMap = array(
               'pt_system'              => 'pt_system'  
              ,'pt_system_zone'         => 'pt_system_zone' 
              ,'pt_event_type'          => 'pt_event_type'
              ,'pt_event'               => 'pt_event'
              ,'pt_score_group'         => 'pt_score_group'
              ,'pt_score'               => 'pt_score'
              ,'pt_rule_group'          => 'pt_rule_group'
              ,'pt_rule_group_limits'   => 'pt_rule_group_limits'
              ,'pt_rule'                => 'pt_rule'
              ,'pt_rule_sys_zone'       => 'pt_rule_sys_zone'
              ,'pt_scoring_transaction' => 'pt_scoring_transaction'
              ,'pt_rule_chain'          => 'pt_rule_chain'
              ,'pt_chain_member'        => 'pt_chain_member'
              // tmp result tables
              ,'pt_result_score'        => 'pt_result_score'
              ,'pt_result_rule'         => 'pt_result_rule'
              ,'pt_result_result'       => 'pt_result_result'
              
            );
        }
        $this['table_map']       = $aTableMap;
        
        #
        # Boostrap the table Gateways
        #
        $c           = $this;
        $oSchema     = new Schema();
        $oGatewayCol = new GatewayProxyCollection($oSchema);
        
        $this['gateway_collection'] = $oGatewayCol;    
        
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
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
        
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('system_id','enabled_from'),'pt_system_uiq1');
           
            $oBuilder = new PointSystemBuilder();
            $oGateway = new PointSystemGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('s');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_system_zone',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_system_zone'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id'   ,'integer' ,array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('zone_id'       ,'guid'    ,array());
            $table->addColumn('zone_name'     ,'string'  ,array("length" => 100));
            $table->addColumn('zone_name_slug','string'  ,array("length" => 100));
            $table->addColumn('system_id'     ,'guid'    ,array("unsigned" => true));
            $table->addColumn('enabled_from'  ,'date',array());
            $table->addColumn('enabled_to'    ,'date',array());
        
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('zone_id','enabled_from'),'pr_sys_zone_uk1');
            $table->addForeignKeyConstraint($aTableMap['pt_system'],array('system_id'),array('system_id'),array(),'pt_sys_zone_fk1');
            
            $oBuilder = new PointSystemZoneBuilder();
            $oGateway = new PointSystemZoneGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('z');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_event_type',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_event_type'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('event_type_id','guid',array());
            $table->addColumn('event_name','string',array("length" => 100));
            $table->addColumn('event_name_slug','string',array("length" => 100));
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
            
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('event_type_id','enabled_from'),'pt_event_type_uiq1');
        
            $oBuilder = new EventTypeBuilder();
            $oGateway = new EventTypeGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('et');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_event',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_event'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('event_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('event_type_id','guid',array("unsigned" => true));
            $table->addColumn('process_date','date',array('comment' => 'Processing date for the calculator'));
            $table->addColumn('occured_date','date',array('comment' => 'When event occured'));
      
            $table->setPrimaryKey(array('event_id'));
            $table->addForeignKeyConstraint($aTableMap['pt_event_type'],array('event_type_id'),array('event_type_id'),array(),'pt_event_fk1');
            
            $oBuilder = new ScoringEventBuilder();
            $oGateway = new ScoringEventGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('se');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_score_group',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_score_group'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('score_group_id','guid',array());
            $table->addColumn('group_name','string',array("length" => 100));
            $table->addColumn('group_name_slug','string',array("length" => 100));
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());  
            
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('score_group_id','enabled_from'),'pt_score_gp_uiq1');
           
            
            $oBuilder = new ScoreGroupBuilder();
            $oGateway = new ScoreGroupGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('sg');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_score',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_score'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('score_id','guid',array());
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
            $table->addColumn('score_name','string',array("length" => 100));
            $table->addColumn('score_name_slug','string',array("length" => 100));
            $table->addColumn('score_value','float',array('signed' => true,'comment' => 'based value for calculations can be + or -'));
            $table->addColumn('score_group_id','guid',array("unsigned" => true));
            
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('score_id','enabled_from'),'pt_score_uiq1');
            $table->addForeignKeyConstraint($aTableMap['pt_score_group'],array('score_group_id'),array('score_group_id'),array(),'pt_score_fk1');
            
            $oBuilder = new ScoreBuilder();
            $oGateway = new ScoreGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('sc');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_rule_group',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_rule_group'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('rule_group_id','guid',array());
            $table->addColumn('rule_group_name','string',array("length" => 100));
            $table->addColumn('rule_group_name_slug','string',array("length" => 100));
            $table->addColumn('enabled_from'  ,'date',array());
            $table->addColumn('enabled_to'    ,'date',array());
            $table->addColumn('max_multiplier','float',array("unsigned" => true, 'comment' => 'Max value of multiplier once all rules are combined in this group allows group capping'));
            $table->addColumn('min_multiplier','float',array("unsigned" => true, 'comment' => 'Min value of multiplier once all rules are combined in this group allows group capping'));
            $table->addColumn('max_modifier'  ,'float',array("unsigned" => true, 'comment' => 'Max value of modifier once all rules are combined in this group allows group capping'));
            $table->addColumn('min_modifier'  ,'float',array("unsigned" => true, 'comment' => 'Min value of modifier once all rules are combined in this group allows group capping'));
            $table->addColumn('max_count'     ,'integer',array("unsigned" => true, 'comment' => 'Max number of scroing rules that can be used that linked to this group'));
            $table->addColumn('order_method'  ,'smallint',array("unsigned" => true, 'comment' => 'method of order to use 1= max 0=min'));
            $table->addColumn('is_mandatory'  ,'smallint',array("unsigned" => true,'comment' => 'Group always be applied unless not linked to system and score groups'));
           
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('rule_group_id','enabled_from'),'pt_rule_gp_uiq1');
                
            $oBuilder = new AdjustmentGroupBuilder();
            $oGateway = new AdjustmentGroupGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('rg');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_rule_group_limits',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_rule_group_limits'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('rule_group_id','guid',array());
            $table->addColumn('score_group_id','guid',array()); 
            $table->addColumn('system_id','guid',array()); 
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
           
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('rule_group_id','system_id','score_group_id','enabled_from'),'pt_rule_gp_limit_uiq1');
            $table->addForeignKeyConstraint($aTableMap['pt_rule_group'],array('rule_group_id'),array('rule_group_id'),array(),'pt_rule_gp_limit_fk1');
            $table->addForeignKeyConstraint($aTableMap['pt_score_group'],array('score_group_id'),array('score_group_id'),array(),'pt_rule_gp_limit_fk2');
            $table->addForeignKeyConstraint($aTableMap['pt_system'],array('system_id'),array('system_id'),array(),'pt_rule_gp_limit_fk3');
                 
            $oBuilder = new AdjustmentGroupLimitBuilder();
            $oGateway = new AdjustmentGroupLimitGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('rgl');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_rule',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_rule'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('rule_id','guid',array());
            $table->addColumn('rule_group_id','guid',array());
            $table->addColumn('rule_name','string',array("length" => 100));
            $table->addColumn('rule_name_slug','string',array("length" => 100));
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
            $table->addColumn('multiplier'  ,'float',array("unsigned" => true, 'comment' => 'Value to multiply the base value by'));
            $table->addColumn('modifier'    ,'integer',array("unsigned" => true, 'comment' => 'value to add to the base'));
            $table->addColumn('invert_flag' ,'smallint',array("unsigned" => true, 'comment' => 'Operation is inverted ie multiplier becomes a divisor'));
               
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('rule_id','rule_group_id','enabled_from'),'pt_rule_uiq1');
            $table->addForeignKeyConstraint($aTableMap['pt_rule_group'],array('rule_group_id'),array('rule_group_id'),array(),'pt_rule_fk1');
          
            $oBuilder = new AdjustmentRuleBuilder();
            $oGateway = new AdjustmentRuleGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('ar');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_rule_sys_zone',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_rule_sys_zone'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('rule_id','guid',array());
            $table->addColumn('zone_id','guid',array()); 
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
            
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('zone_id','rule_id','enabled_from'),'pt_rule_sys_zone_uiq1');
            $table->addForeignKeyConstraint($aTableMap['pt_rule'],array('rule_id'),array('rule_id'),array(),'pt_rule_sys_zone_fk1');
            $table->addForeignKeyConstraint($aTableMap['pt_system_zone'],array('zone_id'),array('zone_id'),array(),'pt_rule_sys_zone_fk2');

            $oBuilder = new AdjustmentZoneBuilder();
            $oGateway = new AdjustmentZoneGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('az');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_scoring_transaction',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_scoring_transaction'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('process_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('rule_id'       ,'integer',array("unsigned" => true));
            $table->addColumn('rule_group_id' ,'integer',array("unsigned" => true,'default'=>null));
            $table->addColumn('score_id'      ,'integer',array("unsigned" => true));
            $table->addColumn('score_group_id','integer',array("unsigned" => true,'default'=>null));
            $table->addColumn('system_id'     ,'integer',array("unsigned" => true));
            $table->addColumn('zone_id'       ,'integer',array("unsigned" => true));
            $table->addColumn('event_type_id' ,'integer',array("unsigned" => true));
            $table->addColumn('event_id'      ,'integer',array("unsigned" => true));
            
            $table->addColumn('score_base'      ,'float',array());
            $table->addColumn('score_balance'   ,'float',array());
            $table->addColumn('score_modifier'  ,'float',array());
            $table->addColumn('score_multiplier','float',array());
            
            $table->addColumn('created_date'    ,'date',array());
            $table->addColumn('processing_date' ,'date',array());
            $table->addColumn('occured_date'    ,'date' ,array());
            
            $table->setPrimaryKey(array('process_id'));
            $table->addForeignKeyConstraint($aTableMap['pt_rule']       ,array('rule_id')       ,array('episode_id') ,array(), 'pt_tran_rule_fk1');
            $table->addForeignKeyConstraint($aTableMap['pt_rule_group'] ,array('rule_group_id') ,array('episode_id') ,array(), 'pt_tran_rule_gp_fk2');
            $table->addForeignKeyConstraint($aTableMap['pt_system']     ,array('system_id')     ,array('episode_id') ,array(), 'pt_tran_sys_fk3');
            $table->addForeignKeyConstraint($aTableMap['pt_system_zone'],array('zone_id')       ,array('episode_id') ,array(), 'pt_tran_sys_zone_fk4');
            $table->addForeignKeyConstraint($aTableMap['pt_score']      ,array('score_id')      ,array('episode_id') ,array(), 'pt_tran_score_fk5');
            $table->addForeignKeyConstraint($aTableMap['pt_score_group'],array('score_group_id'),array('episode_id') ,array(), 'pt_tran_score_gp_fk6');
            $table->addForeignKeyConstraint($aTableMap['pt_event_type'] ,array('event_type_id') ,array('episode_id') ,array(), 'pt_tran_event_type_fk7');
            $table->addForeignKeyConstraint($aTableMap['pt_event']      ,array('event_id')      ,array('event_id')    ,array(), 'pt_tran_event_fk8');
   
           
            $oBuilder = new CalculationBuilder();
            $oGateway = new CalculationGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('t');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_rule_chain',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_rule_chain'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('rule_chain_id','guid',array());
            $table->addColumn('event_type_id','guid',array()); 
            $table->addColumn('system_id','guid',array()); 
            $table->addColumn('chain_name','string',array("length" => 100));
            $table->addColumn('chain_name_slug','string',array("length" => 100));
            $table->addColumn('rounding_option','smallint',array('default'=> 1,'comment' => 'Rounding method to apply floor|ceil|round'));
            $table->addColumn('cap_value','float',array('signed' => true, 'comment' =>'Max value +- that this event type can generate after all calculations have been made'));
            
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
            
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('rule_chain_id','enabled_from'),'pt_rule_chain_uiq1');
            $table->addForeignKeyConstraint($aTableMap['pt_event_type'],array('event_type_id'),array('event_type_id'),array(),'pt_rule_chain_fk1');
            $table->addForeignKeyConstraint($aTableMap['pt_system'],array('system_id'),array('system_id'),array(),'pt_rule_chain_fk2');
            
           
            $oBuilder = new RuleChainBuilder();
            $oGateway = new RuleChainGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('t');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_chain_member',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_chain_member'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Transaction Header Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
            $table->addColumn('chain_member_id','guid',array());
            $table->addColumn('rule_chain_id','guid',array()); 
            $table->addColumn('rule_group_id','guid',array()); 
            $table->addColumn('order_seq','integer',array("unsigned" => true));
            $table->addColumn('enabled_from','date',array());
            $table->addColumn('enabled_to','date',array());
            
            
            $table->setPrimaryKey(array('episode_id'));
            $table->addUniqueIndex(array('chain_member_id','enabled_from'),'pt_chain_member_uiq1');
            $table->addForeignKeyConstraint($aTableMap['pt_rule_chain'],array('rule_chain_id'),array('rule_chain_id'),array(),'pt_chain_member_fk1');
            $table->addForeignKeyConstraint($aTableMap['pt_rule_group'],array('rule_group_id'),array('rule_group_id'),array(),'pt_chain_member_fk2');

            $oBuilder = new RuleChainMemberBuilder();
            $oGateway = new RuleChainMemberGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('t');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('pt_result_score',function() use($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_result_score'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
           
       
            $oTable = $oSchema->createTable($sActualTableName);
            $oTable->addOption('temporary',true); 
            $oTable->addOption('engine','Memory');
            $oTable->addColumn('slot_id','integer',array("unsigned" => true, 'autoincrement' => true, 'comment' => 'Calculation Slot surrogate key'));
            $oTable->addColumn('score_ep','integer',array('notnull' => false,"unsigned" => true, 'comment' => 'Calculation Slot surrogate key'));
            $oTable->addColumn('score_group_ep','integer',array('notnull' => false, "unsigned" => true,'comment' =>'The Score Episode'));
            $oTable->addColumn('system_ep','integer', array('notnull' => false, "unsigned" => true, 'comment' =>'The Points System Episode'));
            $oTable->addColumn('system_zone_ep','integer',array('notnull' => false, "unsigned" => true, 'comment' =>'The Points System Zone Episode'));
            $oTable->addColumn('event_type_ep','integer',array('notnull' => false, "unsigned" => true, 'comment' =>'The Event Type Episode'));
            $oTable->addColumn('score_id'         ,'guid' ,array('notnull' => true,  'comment' =>'The Score Entity'));
            $oTable->addColumn('score_group_id'   ,'guid' ,array('notnull' => false, 'comment' =>'The Score Group Entity'));
            $oTable->addColumn('system_id'        ,'guid' ,array('notnull' => true, 'comment' =>'The Points System Entity'));
            $oTable->addColumn('system_zone_id'   ,'guid' ,array('notnull' => false, 'comment' =>'The Points System Zone Entity'));
            $oTable->addColumn('event_type_id'    ,'guid' ,array('notnull' => true, 'comment' =>'The Event Type Entity'));
            $oTable->addColumn('event_id'         ,'integer'  ,array('notnull' => true, "unsigned" => true,  'comment' => 'The Event Instance Entity'));
            $oTable->addColumn('processing_date'  ,'date'     ,array('notnull' => true,  'comment' => 'What NOW() should be' ));
            $oTable->addColumn('score_base'       ,'float',array('notnull' => false, "unsigned" => false,'comment' =>'Base Score Value' ));
            
            $oTable->setPrimaryKey(array('slot_id'));
            
            $oDriver          = $c->getTableDriver($oTable);
            
            $oGateway         = new TmpScoresGateway($sActualTableName, $oDatabase, $oEvent, $oTable , null, null);
    
            $oGateway->setTableQueryAlias('rs');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            $oGateway->setTableMaker($oDriver);
            
            return $oGateway;
            
        });
        
        
        $oGatewayCol->addGateway('pt_result_rule',function() use($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_result_rule'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
           
       
            $oTable = $oSchema->createTable($sActualTableName);
            $oTable->addOption('temporary',true); 
            $oTable->addOption('engine','Memory');
            $oTable->addColumn('slot_id','integer',array("unsigned" => true, 'autoincrement' => true, 'comment' => 'Calculation Slot surrogate key'));
            $oTable->addColumn('system_ep','integer', array('notnull' => true, "unsigned" => true, 'comment' =>'The Points System Episode'));
            $oTable->addColumn('system_zone_ep','integer',array('notnull' => false, "unsigned" => true, 'comment' =>'The Points System Zone Episode'));
            $oTable->addColumn('rule_ep','integer',array('notnull' => false, "unsigned" => true, 'comment' =>'The Adj Rule Episode'));
            $oTable->addColumn('rule_group_ep','integer'   ,array('notnull' => false, "unsigned" => true, 'comment' =>'The Adj Rule Group Episode'));
            $oTable->addColumn('rule_chain_ep','integer'   ,array('notnull' => false, "unsigned" => true, 'comment' =>'The Rule Chain Episode'));
            $oTable->addColumn('chain_member_ep','integer' ,array('notnull' => false, "unsigned" => true, 'comment' =>'The Rule Chain Member Episode'));
            $oTable->addColumn('system_id'        ,'guid' ,array('notnull' => true, 'comment' =>'The Points System Entity'));
            $oTable->addColumn('system_zone_id'   ,'guid' ,array('notnull' => false, 'comment' =>'The Points System Zone Entity'));
            $oTable->addColumn('event_type_id'    ,'guid' ,array('notnull' => true, 'comment' =>'The Event Type Entity'));
            $oTable->addColumn('rule_id'          ,'guid' ,array('notnull' => false, 'comment' =>'The Adj Rule Entity'));
            $oTable->addColumn('rule_group_id'    ,'guid' ,array('notnull' => false, 'comment' =>'The Adj Group Entity'));
            $oTable->addColumn('rule_chain_id'    ,'guid' ,array('notnull' => false,  'comment' =>'The Rule Chain Entity'));
            $oTable->addColumn('chain_member_id'  ,'guid' ,array('notnull' => false, 'comment' =>'The Rule Chain Entity'));
            $oTable->addColumn('event_id'         ,'integer'  ,array('notnull' => true, "unsigned" => true,  'comment' => 'The Event Instance Entity'));
            $oTable->addColumn('processing_date'  ,'date'     ,array('notnull' => true,  'comment' => 'What NOW() should be' ));
            $oTable->addColumn('rule_order_seq'   ,'integer'  ,array('notnull' => false, 'comment' => 'Adj Rule order inside a group'  ));
            $oTable->addColumn('group_order_seq'  ,'integer'  ,array('notnull' => false, 'comment' => 'Adj Group order in a chain' ));
            $oTable->addColumn('score_modifier'   ,'float',array('notnull' => false, "unsigned" => false,'comment' => 'Modifier Value' ));
            $oTable->addColumn('score_multiplier' ,'float',array('notnull' => false, "unsigned" => false,'comment' => 'Multiplier Value'));
            $oTable->addColumn('cap_remaining'    ,'float',array('notnull' => false, "unsigned" => true, 'comment' => 'Remaining Cap'));
        
        
            
            $oTable->setPrimaryKey(array('slot_id'));
            
            $oDriver          = $c->getTableDriver($oTable);
            
            $oGateway         = new TmpAdjRuleGateway($sActualTableName, $oDatabase, $oEvent, $oTable , null, null);
    
            $oGateway->setTableQueryAlias('rs');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            $oGateway->setTableMaker($oDriver);
            
            return $oGateway;
            
        });
        $oGatewayCol->addGateway('pt_result_result',function() use($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['pt_result_result'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
           
       
            $oTable = $oSchema->createTable($sActualTableName);
            $oTable->addOption('temporary',true); 
            $oTable->addOption('engine','Memory');
            
            
            # pk of table
            $oTable->addColumn('slot_id','integer',array("unsigned" => true, 'autoincrement' => true, 'comment' => 'Calculation Slot surrogate key'));
           
            
            # Episode References
            $oTable->addColumn('score_ep','integer',array('notnull' => true,"unsigned" => true, 'comment' => 'Calculation Slot surrogate key'));
            $oTable->addColumn('score_group_ep','integer',array('notnull' => false, "unsigned" => true,'comment' =>'The Score Episode'));
            $oTable->addColumn('system_ep','integer', array('notnull' => true, "unsigned" => true, 'comment' =>'The Points System Episode'));
            $oTable->addColumn('system_zone_ep','integer',array('notnull' => false, "unsigned" => true, 'comment' =>'The Points System Zone Episode'));
            $oTable->addColumn('rule_ep','integer',array('notnull' => false, "unsigned" => true, 'comment' =>'The Adj Rule Episode'));
            
            $oTable->addColumn('rule_group_ep','integer'   ,array('notnull' => false, "unsigned" => true, 'comment' =>'The Adj Rule Group Episode'));
            $oTable->addColumn('rule_chain_ep','integer'   ,array('notnull' => false, "unsigned" => true, 'comment' =>'The Rule Chain Episode'));
            $oTable->addColumn('chain_member_ep','integer' ,array('notnull' => false, "unsigned" => true, 'comment' =>'The Rule Chain Member Episode'));
            
            # Entity References
            $oTable->addColumn('score_id'         ,'guid' ,array('notnull' => true,  'comment' =>'The Score Entity'));
            $oTable->addColumn('score_group_id'   ,'guid' ,array('notnull' => false, 'comment' =>'The Score Group Entity'));
            $oTable->addColumn('system_id'        ,'guid' ,array('notnull' => true, 'comment' =>'The Points System Entity'));
            $oTable->addColumn('system_zone_id'   ,'guid' ,array('notnull' => false, 'comment' =>'The Points System Zone Entity'));
            $oTable->addColumn('event_type_id'    ,'guid' ,array('notnull' => true, 'comment' =>'The Event Type Entity'));
            $oTable->addColumn('rule_id'          ,'guid' ,array('notnull' => false, 'comment' =>'The Adj Rule Entity'));
            $oTable->addColumn('rule_group_id'    ,'guid' ,array('notnull' => false, 'comment' =>'The Adj Group Entity'));
            $oTable->addColumn('rule_chain_id'    ,'guid' ,array('notnull' => false,  'comment' =>'The Rule Chain Entity'));
            $oTable->addColumn('chain_member_id'  ,'guid' ,array('notnull' => false, 'comment' =>'The Rule Chain Entity'));
            
            # Normal Fields
            $oTable->addColumn('event_id'         ,'integer'  ,array('notnull' => true, "unsigned" => true,  'comment' => 'The Event Instance Entity'));
            $oTable->addColumn('processing_date'  ,'date'     ,array('notnull' => true,  'comment' => 'What NOW() should be' ));
            $oTable->addColumn('rule_order_seq'   ,'integer'  ,array('notnull' => false, 'comment' => 'Adj Rule order inside a group'  ));
            $oTable->addColumn('group_order_seq'  ,'integer'  ,array('notnull' => false, 'comment' => 'Adj Group order in a chain' ));
            
            $oTable->addColumn('score_base'       ,'float',array('notnull' => false, "unsigned" => false,'comment' =>'Base Score Value' ));
            $oTable->addColumn('score_modifier'   ,'float',array('notnull' => false, "unsigned" => false,'comment' => 'Modifier Value' ));
            $oTable->addColumn('score_multiplier' ,'float',array('notnull' => false, "unsigned" => false,'comment' => 'Multiplier Value'));
            $oTable->addColumn('cap_remaining'    ,'float',array('notnull' => false, "unsigned" => true, 'comment' => 'Remaining Cap'));

        
            
            $oTable->setPrimaryKey(array('slot_id'));
            
            $oDriver          = $c->getTableDriver($oTable);
            
            $oGateway         = new TmpResultsGateway($sActualTableName, $oDatabase, $oEvent, $oTable , null, null);
    
            $oGateway->setTableQueryAlias('rs');
            $oGateway->setGatewayCollection($c->getGatewayCollection());
            $oGateway->setTableMaker($oDriver);
            
            return $oGateway;
            
        });
        
        
      
       $this['table_factory'] = $this->share(function($c){
          return new DriverFactory();
       });
      
       
        
    }
    
}
/* End of Class */