<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use DBALGateway\Metadata\Table;

class MYSQLDriver implements DriverInterface
{
    
    /**
     * @var Doctrine\DBAL\Connection
    */ 
    protected $oAdapter;
    
    /**
     * @varDBALGateway\Metadata\Table
     */ 
    protected $oTable;
    
    
    protected function getDefinition($sTmpTableName)
    {
        $oTable = new Table($sTmpTableName);
       
        # set Mysql Options
        $oTable->addOption('temporary',true); 
        $oTable->addOption('engine','Memory');
        
        
        # pk of table
        $oTable->addColumn('slot_id','integer',array("unsigned" => true, 'autoincrement' => true, 'comment' => 'Calculation Slot surrogate key'));
        $oTable->setPrimaryKey(array('slot_id'));
        
        
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
        
        return $oTable;
        
    }
    
    
    public function __construct(Connection $oAdapter, $sTmpTableName)
    {
        $this->oAdapter = $oAdapter;
        $this->oTable   = $this->getDefinition($sTmpTableName);
       
    }
    
    
    /**
     * Create the tmp table
     * 
     * @access public
     * @return boolean if the table was created
     */ 
    public function createTable()
    {
        $oDatabase     = $this->getDatabaseAdaper();
        $sNewTableName = $this->getTableMeta()->getName();
        $oTable        = $this->getTableMeta();
        try {
            
            $aSql =  $oDatabase->getDatabasePlatform()
                                ->getCreateTableSQL($oTable);
            
            foreach($aSql as $sSql) {
                $oDatabase->executeUpdate($sSql);    
            }
            
            
        } catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
        }
        
    }
    
    
    /**
     * Truncate a temp table
     * 
     * @return void
     * @access public
     */ 
    public function truncateTable()
    {
        $oDatabase     = $this->getDatabaseAdaper();
        $sTableName    = $this->getTableMeta()->getName();
        
        
        $sSql  = "TRUNCATE $sTableName";
        
        try {
            
            $oDatabase->executeUpdate($sSql);
            
        } catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
        }
        
        
    }
    
    
    /**
     * Delete the tmp table
     * 
     * @access public
     * @return bool if table removed
     */ 
    public function removeTable()
    {
        $oDatabase     = $this->getDatabaseAdaper();
        $sTableName    = $this->getTableMeta()->getName();
    
    
        $sSql = "DROP TEMPORARY TABLE $sTableName";
        
        try {
            
            $oDatabase->executeUpdate($sSql);
            
        } catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
        }
    }
    
    
   
    
    /**
     * Return the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper()
    {
        return $this->oAdapter;
    }
    
    
    /**
     * Return the table schema object
     * 
     * @return DBALGateway\Metadata\Table
     */ 
    public function getTableMeta()
    {
        return $this->oTable;
    }
    
    
    
}
/* End of Class */