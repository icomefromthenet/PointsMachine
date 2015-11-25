<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Doctrine\DBAL\Schema\Schema as ASchema,
    Migration\Components\Migration\EntityInterface;

class init_schema implements EntityInterface
{

    protected function getSystemTable(Connection $db, ASchema $sc)
    {
        # Systems Table
        $table = $sc->createTable("pt_system");
        $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
        $table->addColumn('system_id','guid',array());
        $table->addColumn('system_name','string',array("length" => 100));
        $table->addColumn('system_name_slug','string',array("length" => 100));
        $table->addColumn('enabled_from','date',array());
        $table->addColumn('enabled_to','date',array());
    
        $table->setPrimaryKey(array('episode_id'));
        $table->addUniqueIndex(array('system_id','enabled_to'),'pt_system_uiq1');
        
        
        $table = $sc->createTable("pt_system_zone");
        $table->addColumn('episode_id'   ,'integer' ,array("unsigned" => true,'autoincrement' => true));
        $table->addColumn('zone_id'       ,'guid'    ,array());
        $table->addColumn('zone_name'     ,'string'  ,array("length" => 100));
        $table->addColumn('zone_name_slug','string'  ,array("length" => 100));
        $table->addColumn('system_id'     ,'guid'    ,array("unsigned" => true));
        $table->addColumn('enabled_from'  ,'date',array());
        $table->addColumn('enabled_to'    ,'date',array());
    
        $table->setPrimaryKey(array('episode_id'));
        $table->addUniqueIndex(array('zone_id','enabled_to'),'pr_sys_zone_uk1');
        $table->addForeignKeyConstraint('pt_system',array('system_id'),array('system_id'),array(),'pt_sys_zone_fk1');
        
        
    }

    protected function getEventsTables(Connection $db, ASchema $sc)
    {
        # Event Types
        $table = $sc->createTable("pt_event_type");
        $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
        $table->addColumn('event_type_id','guid',array());
        $table->addColumn('event_name','string',array("length" => 100));
        $table->addColumn('event_name_slug','string',array("length" => 100));
        $table->addColumn('enabled_from','date',array());
        $table->addColumn('enabled_to','date',array());
        
        $table->setPrimaryKey(array('episode_id'));
        $table->addUniqueIndex(array('event_type_id','enabled_to'),'pt_event_type_uiq1');
        
        
        # Event Instances
        $table = $sc->createTable("pt_event");
        $table->addColumn('event_id','integer',array("unsigned" => true,'autoincrement' => true));
        $table->addColumn('event_type_id','guid',array("unsigned" => true));
        $table->addColumn('process_date','date',array('comment' => 'Processing date for the calculator'));
        $table->addColumn('occured_date','date',array('comment' => 'When event occured'));
      
        
        $table->setPrimaryKey(array('event_id'));
        $table->addForeignKeyConstraint('pt_event_type',array('event_type_id'),array('event_type_id'),array(),'pt_event_fk1');
        
        
        
    }
   
   protected function getScoresTables(Connection $db, ASchema $sc)
   {
        
        # Groups table for Scores
        $table = $sc->createTable("pt_score_group");
        $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
        $table->addColumn('score_group_id','guid',array());
        $table->addColumn('group_name','string',array("length" => 100));
        $table->addColumn('group_name_slug','string',array("length" => 100));
        $table->addColumn('enabled_from','date',array());
        $table->addColumn('enabled_to','date',array());  
        
        $table->setPrimaryKey(array('episode_id'));
        $table->addUniqueIndex(array('score_group_id','enabled_to'),'pt_score_gp_uiq1');
        
        
        # Scores instance table
        $table = $sc->createTable("pt_score");
        $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
        $table->addColumn('score_id','guid',array());
        $table->addColumn('enabled_from','date',array());
        $table->addColumn('enabled_to','date',array());
        $table->addColumn('score_name','string',array("length" => 100));
        $table->addColumn('score_name_slug','string',array("length" => 100));
        $table->addColumn('score_value','float',array('signed' => true,'comment' => 'based value for calculations can be + or -'));
        $table->addColumn('score_group_id','guid',array("unsigned" => true));
        
        $table->setPrimaryKey(array('episode_id'));
        $table->addUniqueIndex(array('score_id','enabled_to'),'pt_score_uiq1');
        $table->addForeignKeyConstraint('pt_score_group',array('score_group_id'),array('score_group_id'),array(),'pt_score_fk1');
        
   }
 
   
   protected function getScoringRulesTables(Connection $db, ASchema $sc)
   {
       # Rule Group
       $table = $sc->createTable("pt_rule_group");
       $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
       $table->addColumn('rule_group_id','guid',array());
       $table->addColumn('rule_group_name','string',array("length" => 100));
       $table->addColumn('rule_group_name_slug','string',array("length" => 100));
       $table->addColumn('enabled_from'  ,'date',array());
       $table->addColumn('enabled_to'    ,'date',array());
       $table->addColumn('max_multiplier','float',array("unsigned" => true, 'comment' => 'Max value of multiplier once all rules are combined in this group allows group capping','notnull' => false));
       $table->addColumn('min_multiplier','float',array("unsigned" => true, 'comment' => 'Min value of multiplier once all rules are combined in this group allows group capping','notnull' => false));
       $table->addColumn('max_modifier'  ,'float',array("unsigned" => true, 'comment' => 'Max value of modifier once all rules are combined in this group allows group capping','notnull' => false));
       $table->addColumn('min_modifier'  ,'float',array("unsigned" => true, 'comment' => 'Min value of modifier once all rules are combined in this group allows group capping','notnull' => false));
       $table->addColumn('max_count'     ,'integer',array("unsigned" => true, 'comment' => 'Max number of scroing rules that can be used that linked to this group'));
       $table->addColumn('order_method'  ,'smallint',array("default" => 1, "unsigned" => true, 'comment' => 'method of order to use 1= max 0=min','notnull' => false));
       $table->addColumn('is_mandatory'  ,'smallint',array("unsigned" => true,'comment' => 'Group always be applied unless not linked to system and score groups'));
       
       $table->setPrimaryKey(array('episode_id'));
       $table->addUniqueIndex(array('rule_group_id','enabled_to'),'pt_rule_gp_uiq1');
       
       
       # Rule Group Scores Groups Relations
       $table = $sc->createTable("pt_rule_group_limits");
       $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
       $table->addColumn('rule_group_id','guid',array());
       $table->addColumn('score_group_id','guid',array('notnull' => false)); 
       $table->addColumn('system_id','guid',array('notnull' => false)); 
       $table->addColumn('enabled_from','date',array());
       $table->addColumn('enabled_to','date',array());
       
       $table->setPrimaryKey(array('episode_id'));
       $table->addUniqueIndex(array('rule_group_id','system_id','score_group_id','enabled_to'),'pt_rule_gp_limit_uiq1');
       $table->addForeignKeyConstraint('pt_rule_group',array('rule_group_id'),array('rule_group_id'),array(),'pt_rule_gp_limit_fk1');
       $table->addForeignKeyConstraint('pt_score_group',array('score_group_id'),array('score_group_id'),array(),'pt_rule_gp_limit_fk2');
       $table->addForeignKeyConstraint('pt_system',array('system_id'),array('system_id'),array(),'pt_rule_gp_limit_fk3');
       
       
       # Rule bTables
       $table = $sc->createTable("pt_rule");
       $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
       $table->addColumn('rule_id','guid',array());
       $table->addColumn('rule_group_id','guid',array());
       $table->addColumn('rule_name','string',array("length" => 100));
       $table->addColumn('rule_name_slug','string',array("length" => 100));
       $table->addColumn('enabled_from','date',array());
       $table->addColumn('enabled_to','date',array());
       $table->addColumn('multiplier'  ,'float',array("unsigned" => false, 'comment' => 'Value to multiply the base value by','notnull' => false));
       $table->addColumn('modifier'    ,'float',array("unsigned" => false, 'comment' => 'value to add to the base','notnull' => false));
       $table->addColumn('invert_flag' ,'smallint',array("unsigned" => true, 'comment' => 'Operation is inverted ie multiplier becomes a divisor','notnull' => false));
       
       
       $table->setPrimaryKey(array('episode_id'));
       $table->addUniqueIndex(array('rule_id','rule_group_id','enabled_to'),'pt_rule_uiq1');
       $table->addForeignKeyConstraint('pt_rule_group',array('rule_group_id'),array('rule_group_id'),array(),'pt_rule_fk1');
    
       
       # Rule System Zones
       $table = $sc->createTable("pt_rule_sys_zone");
       $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
       $table->addColumn('rule_id','guid',array());
       $table->addColumn('zone_id','guid',array()); 
       $table->addColumn('enabled_from','date',array());
       $table->addColumn('enabled_to','date',array());

       $table->setPrimaryKey(array('episode_id'));
       $table->addUniqueIndex(array('zone_id','rule_id','enabled_to'),'pt_rule_sys_zone_uiq1');
       $table->addForeignKeyConstraint('pt_rule',array('rule_id'),array('rule_id'),array(),'pt_rule_sys_zone_fk1');
       $table->addForeignKeyConstraint('pt_system_zone',array('zone_id'),array('zone_id'),array(),'pt_rule_sys_zone_fk2');
       
       
       # Score transaction
        $table = $sc->createTable("pt_transaction_header");
        $table->addColumn('event_id'      ,'integer',array("unsigned" => true));
        $table->addColumn('system_ep'     ,'integer',array("unsigned" => true));
        $table->addColumn('zone_ep'       ,'integer',array("unsigned" => true));
        $table->addColumn('event_type_ep' ,'integer',array("unsigned" => true));
        $table->addColumn('created_date'    ,'date',array());
        $table->addColumn('processing_date' ,'date',array());
        $table->addColumn('occured_date'    ,'date' ,array());
        
        $table->setPrimaryKey(array('event_id'));

        $table->addForeignKeyConstraint('pt_system'     ,array('system_ep')     ,array('episode_id') ,array(), 'pt_tran_head_sys_fk1');
        $table->addForeignKeyConstraint('pt_system_zone',array('zone_ep')       ,array('episode_id') ,array(), 'pt_tran_head_zone_fk2');        
        $table->addForeignKeyConstraint('pt_event_type' ,array('event_type_ep') ,array('episode_id') ,array(), 'pt_tran_head_event_type_fk3');
        $table->addForeignKeyConstraint('pt_event'      ,array('event_id')      ,array('event_id')    ,array(), 'pt_tran_head_event_fk4');

        
        # Score Totals  
        $table = $sc->createTable("pt_transaction_score");
        $table->addColumn('event_id'          ,'integer',array("unsigned" => true));
        $table->addColumn('score_ep'          ,'integer',array("unsigned" => true));
        $table->addColumn('score_group_ep'    ,'integer',array("unsigned" => true,'default'=>null));
        $table->addColumn('score_base'        ,'float'  ,array("unsigned" => false,'default'=>0));
        $table->addColumn('score_cal_raw'     ,'float'  ,array("unsigned" => false,'default'=>0));
        $table->addColumn('score_cal_rounded' ,'float'  ,array("unsigned" => false,'default'=>0));
        $table->addColumn('score_cal_capped'  ,'float'  ,array("unsigned" => false,'default'=>0));
        
        
        $table->setPrimaryKey(array('event_id','score_ep'));
        $table->addForeignKeyConstraint('pt_score'      ,array('score_ep')      ,array('episode_id') ,array(), 'pt_tran_sc_score_fk1');
        $table->addForeignKeyConstraint('pt_score_group',array('score_group_ep'),array('episode_id') ,array(), 'pt_tran_sc_score_gp_fk2');
        $table->addForeignKeyConstraint('pt_event'      ,array('event_id')      ,array('event_id')    ,array(), 'pt_tran_sc_event_fk3');
        
        # Adj Group Transaction
        $table = $sc->createTable("pt_transaction_group");
        $table->addColumn('event_id','integer',array("unsigned" => true));
        $table->addColumn('score_ep'      ,'integer',array("unsigned" => true));
        $table->addColumn('rule_group_ep' ,'integer',array("unsigned" => true,'default'=>null));
        $table->addColumn('score_modifier'  ,'float',array());
        $table->addColumn('score_multiplier','float',array());
        $table->addColumn('order_seq','integer',array("unsigned" => true));
        
        $table->setPrimaryKey(array('event_id','score_ep','rule_group_ep'));
        $table->addForeignKeyConstraint('pt_event'      ,array('event_id')      ,array('event_id')    ,array(), 'pt_tran_gp_event_fk1');
        $table->addForeignKeyConstraint('pt_score'      ,array('score_ep')      ,array('episode_id') ,array(), 'pt_tran_gp_score_fk2');
        $table->addForeignKeyConstraint('pt_rule_group' ,array('rule_group_ep') ,array('episode_id') ,array(), 'pt_tran_gp_rulgp_fk3');
        
        
        # Adj Rule Transactions'
        $table = $sc->createTable("pt_transaction_rule");
        $table->addColumn('event_id','integer',array("unsigned" => true));
        $table->addColumn('score_ep'      ,'integer',array("unsigned" => true));       
        $table->addColumn('rule_ep'       ,'integer',array("unsigned" => true));
        $table->addColumn('score_modifier'  ,'float',array());
        $table->addColumn('score_multiplier','float',array());
        $table->addColumn('order_seq','integer',array("unsigned" => true));
        
        $table->setPrimaryKey(array('event_id','score_ep','rule_ep'));
        $table->addForeignKeyConstraint('pt_event'      ,array('event_id')      ,array('event_id')    ,array(), 'pt_tran_rule_event_fk1');
        $table->addForeignKeyConstraint('pt_score'      ,array('score_ep')      ,array('episode_id') ,array(), 'pt_tran_rule_score_fk2');
        $table->addForeignKeyConstraint('pt_rule'       ,array('rule_ep')       ,array('episode_id') ,array(), 'pt_tran_rule_rule_fk3');
    }
   
   
   public function getRuleChain(Connection $db, ASchema $sc)
   {
       # Rule Chains
       $table = $sc->createTable("pt_rule_chain");
       $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
       $table->addColumn('rule_chain_id','guid',array());
       $table->addColumn('event_type_id','guid',array()); 
       $table->addColumn('system_id','guid',array()); 
       $table->addColumn('chain_name','string',array("length" => 100));
       $table->addColumn('chain_name_slug','string',array("length" => 100));
       $table->addColumn('rounding_option','smallint',array('default'=> 0,'comment' => 'Rounding method to apply floor|ceil|round'));
       $table->addColumn('cap_value','float',array('notnull' => false,'signed' => true, 'comment' =>'Max value +- that this event type can generate after all calculations have been made'));
     
       $table->addColumn('enabled_from','date',array());
       $table->addColumn('enabled_to','date',array());

       $table->setPrimaryKey(array('episode_id'));
       $table->addUniqueIndex(array('rule_chain_id','enabled_to'),'pt_rule_chain_uiq1');
       $table->addForeignKeyConstraint('pt_event_type',array('event_type_id'),array('event_type_id'),array(),'pt_rule_chain_fk1');
       $table->addForeignKeyConstraint('pt_system',array('system_id'),array('system_id'),array(),'pt_rule_chain_fk2');
       
       # Chain memeber table
       $table = $sc->createTable("pt_chain_member");
       $table->addColumn('episode_id','integer',array("unsigned" => true,'autoincrement' => true));
       $table->addColumn('chain_member_id','guid',array());
       $table->addColumn('rule_chain_id','guid',array()); 
       $table->addColumn('rule_group_id','guid',array()); 
       $table->addColumn('order_seq','integer',array("unsigned" => true));
       $table->addColumn('enabled_from','date',array());
       $table->addColumn('enabled_to','date',array());

    
       $table->setPrimaryKey(array('episode_id'));
       $table->addUniqueIndex(array('chain_member_id','enabled_to'),'pt_chain_member_uiq1');
       $table->addForeignKeyConstraint('pt_rule_chain',array('rule_chain_id'),array('rule_chain_id'),array(),'pt_chain_member_fk1');
       $table->addForeignKeyConstraint('pt_rule_group',array('rule_group_id'),array('rule_group_id'),array(),'pt_chain_member_fk2');
       
       
   }
    
    public function buildSchema(Connection $db, ASchema $schema)
    {
        
        $this->getSystemTable($db,$schema);
        $this->getEventsTables($db,$schema);
        $this->getScoresTables($db,$schema);
        $this->getScoringRulesTables($db,$schema);
        $this->getRuleChain($db,$schema);
        
        return $schema;
    }
    
    public function up(Connection $db, Schema $sc)
    {
        
        
        $schema = $this->buildSchema($db,new ASchema());
        
        $queries = $schema->toSql($db->getDatabasePlatform()); // get queries to create this schema.
        
        # execute setup queries
        foreach($queries as $query) {
            
            echo $query . PHP_EOL;
            $db->exec($query);    
        }
        
    }

    public function down(Connection $db, Schema $sc)
    {


    }


}
/* End of File */