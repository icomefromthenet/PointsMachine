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
    
    /**
     * @var constanced used to order when the pass will execute.
     */ 
    const PASS_PRIORITY = 0;
    
    const ROUND_OFF    = 0;

    const ROUND_NORMAL = 1;
    
    const ROUND_CEIL  = 2;
    
    const ROUND_FLOOR = 3;
   
   
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
     * Return the database adapter
     *  
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdapter()
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
    

    /**
     * Return the Compiler Tmp table Driver
     * 
     * @param string    $sTable The tmp table name
     * @return  IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface
     * 
     */ 
    public function getTableMaker($sTable)
    {
        return $this->getGatewayCollection()
                            ->getGateway($sTable)
                            ->getTableMaker();
        
    }

    //--------------------------------------------------------
    # Tmp Tables


    /**
     * Return the common table name
     * 
     * @return string the name of the common tmp table
     */ 
    public function getCommonTmpTableName()
    {
         return $this->getGatewayCollection()
                            ->getGateway('pt_result_common')
                            ->getMetaData()
                            ->getName();
        
    }
    
    /**
     * Fetch the table name for this rules tmp table
     *  
     * @return string the tmp table name
     * @access protected
     */ 
    protected function getRuleTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_rule')
                            ->getMetaData()
                            ->getName();
        
    }
    
    /**
     * Fetch the table name for the Score tmp table
     *  
     * @return string the tmp table name
     * @access protected
     */
    protected function getScoreTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_score')
                            ->getMetaData()
                            ->getName();
        
    }
    
    
    /**
     * Fetch the table name for this CJoin tmp table
     *  
     * @return string the tmp table name
     * @access protected
     */
    protected function getCJoinTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_cjoin')
                            ->getMetaData()
                            ->getName();
        
    }
    
    /**
     * Fetch the table name for this rank tmp table
     *  
     * @return string the tmp table name
     * @access protected
     */
    protected function getRankTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_rank')
                            ->getMetaData()
                            ->getName();
        
    }
    
     

    
    /**
     * Fetch the table name for this aggrate result table
     *  
     * @return string the tmp table name
     * @access protected
     */
    protected function getAggValueTmpTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_result_agg')
                            ->getMetaData()
                            ->getName();
        
        
    }


    // ----------------------------------------------------
    # Transcation Tables
    
    
    /**
     * Fetch the table name for the transaction adj rules log table
     *  
     * @return string the table name
     * @access protected
     */
    protected function getTransactionAdjRuleTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_transaction_rule')
                            ->getMetaData()
                            ->getName();

    }    
    
    /**
     * Fetch the table name for the transaction adj group rules log table
     *  
     * @return string the table name
     * @access protected
     */
    protected function getTransactionAdjGroupTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_transaction_group')
                            ->getMetaData()
                            ->getName();

    }    
    
    /**
     * Fetch the table name for the transaction scores log table
     *  
     * @return string the table name
     * @access protected
     */
    protected function getTransactionScoreTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_transaction_score')
                            ->getMetaData()
                            ->getName();

    }    
    
    /**
     * Fetch the table name for the transaction event log table
     *  
     * @return string the table name
     * @access protected
     */
    protected function getTransactionEventTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_transaction_header')
                            ->getMetaData()
                            ->getName();

    }    
   
    
    //-----------------------------------------------
    # Normal Tables
    
    /**
     * Fetch the table name for the rule table
     *  
     * @return string the table name
     * @access protected
     */
    protected function getRuleTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_rule')
                            ->getMetaData()
                            ->getName();
        
    }
    
    /**
     * Fetch the table name for the rule table
     *  
     * @return string the table name
     * @access protected
     */
    protected function getRuleGroupTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_rule_group')
                            ->getMetaData()
                            ->getName();
        
    }
    
    /**
     * Fetch the table chain member table
     *  
     * @return string the table name
     * @access protected
     */
    protected function getChainMemberTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_chain_member')
                            ->getMetaData()
                            ->getName();
        
    }
    
    /**
     * Fetch the table chain name
     *  
     * @return string the table name
     * @access protected
     */
    protected function getChainTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_rule_chain')
                            ->getMetaData()
                            ->getName();
        
    }
    
    /**
     * Fetch the system table name
     *  
     * @return string the table name
     * @access protected
     */
    protected function getSystemTableName()
    {
        return $this->getGatewayCollection()
                            ->getGateway('pt_system')
                            ->getMetaData()
                            ->getName();                    
        
    }
    
    
    /**
     * Fetch the system zone table name
     *  
     * @return string the table name
     * @access protected
     */
    protected function getSystemZoneTableName()
    {
        return  $this->getGatewayCollection()
                            ->getGateway('pt_system_zone')
                            ->getMetaData()
                            ->getName();  
        
    }
    
    /**
     * Fetch the event type table name
     *  
     * @return string the table name
     * @access protected
     */
    protected function getEventTypeTableName()
    {
        return  $this->getGatewayCollection()
                            ->getGateway('pt_event_type')
                            ->getMetaData()
                            ->getName();  
        
    }
    
    /**
     * Fetch the score table name
     *  
     * @return string the table name
     * @access protected
     */
    protected function getScoreTableName()
    {
        return  $this->getGatewayCollection()
                            ->getGateway('pt_score')
                            ->getMetaData()
                            ->getName();  
        
    }
    
    /**
     * Fetch the score group table name
     *  
     * @return string the table name
     * @access protected
     */
    protected function getScoreGroupTableName()
    {
        return  $this->getGatewayCollection()
                            ->getGateway('pt_score_group')
                            ->getMetaData()
                            ->getName();  
        
    }
    
}
/* End of Pass */