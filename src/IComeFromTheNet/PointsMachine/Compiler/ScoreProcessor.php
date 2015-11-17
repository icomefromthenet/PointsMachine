<?php
namespace IComeFromTheNet\PointsMachine\Compiler;

use \DateTime;
use Doctrine\DBAL\Connection;
use PSR\Log\LoggerInterface;
use DBALGateway\Table\GatewayProxyCollection;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * This class used to execute the scoring compiler passes
 * and log each execution. 
 * 
 * After execution has finishes the result stored in Adjustment Scores
 * transction table will be loaded. 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 0.1
 */ 
class ScoreProcessor implements CompilerInterface
{
    
    /**
     * @var Doctrine\DBAL\Connection
     */  
    protected $oAdapter;
    
    /**
     * @var DBALGateway\Table\GatewayProxyCollection
     */  
    protected $oGatewayCollection;

    /**
     * @var array [IComeFromTheNet\PointsMachine\Compiler\CompilerPassInterface]
     */ 
    protected $aPasses;
    

    /**
     * @var LoggerInterface
     */ 
    protected $oLogger;
    
    
    public function __construct(Connection $oAdapter, LoggerInterface $oLogger, GatewayProxyCollection $oGateways)
    {
        $this->oAdapter             = $oAdapter;
        $this->oLogger              = $oLogger; 
        $this->oGatewayCollecetion  = $oGateways;
    }
    
    
    /**
     * Start the complier
     * 
     * @access public
     * @return void
     * @param ComplileResult    $oResult
     * @param DateTime          $oProcessingDate
     */ 
    public function execute(DateTime $oProcessingDate, ComplileResult $oResult)
    {

        try {
            
            // Execute Each Pass
            $this->getLogger()->info('Starting Execute PointsMachine Score Compiler for Processing Date ::'.$oProcessingDate->format('d-m-Y'));
            
            foreach($this->aPasses as $oPass) {
                
                $this->getLogger()->debug('Starting Pass ::'.get_class($oPass));
                
                $oPass->execute($oProcessingDate,$oResult);
                
                $this->getLogger()->debug('Finished Pass ::'.get_class($oPass));
            
            }
            
            $this->getLogger()->info('Finished Executing PointsMachine Score Compiler');

            
        } catch(PointsMachineException $e) {
            if(get_class($oPass)) {
                $this->getLogger()->error('Error Execute Pass '.get_class($oPass). '::'.$e->getMessage());    
            }
            else {
                $this->getLogger()->error('Error Execute Unknown Pass ::'. $e->getMessage());
            }
                        
            throw $e;
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
     * Fetch the assigned logger
     * 
     * @return LoggerInterface
     */ 
    public function getLogger()
    {
        return $this->oLogger;
    }

    /**
     * Add a pass to this complier, passes will be executed in 
     * the order they are added.
     * 
     * @param CompilerPassInterface $oPass  the pass to add.
     * @return void
     * 
     */ 
    public function addPass(CompilerPassInterface $oPass)
    {
        if(true === isset($this->aPasses[$oPass::PASS_PRIORITY])) {
            throw new PointsMachineException('Error compiler pass ::'.get_class($oPass).' using a priority that already been used');
        }
        
        $this->aPasses[$oPass::PASS_PRIORITY] = $oPass;
    }
    
    /**
     * Return the result stored in the transaction tables.
     * 
     * @access public
     * @return array
     * @param integer The Event Instance To find
     */ 
    public function getResult($iEventId)
    {
        $oScoreTransactionGateway = $this->oGatewayCollection->getGateway('pt_transaction_score');
                        
        
        return $oScoreTransactionGateway
            ->selectQuery()
             ->start()
                ->andWhere('event_id',$iEventId)
             ->end()
           ->find();
        

    }
    
    
}