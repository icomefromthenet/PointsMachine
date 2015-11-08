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
}
/* End of Pass */