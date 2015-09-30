<?php
namespace IComeFromTheNet\PointsMachine\Compiler;

use \DateTime;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * This complier used to combine a number of score rules.
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
     * @var string the result tmp table name
     */ 
    protected $sResultTableName;
    
    /**
     * @var array [IComeFromTheNet\PointsMachine\Compiler\CompilerPassInterface]
     */ 
    protected $aPasses;
    
    /**
     * @var CompileResult
     */ 
    protected $oLastResult;
    
    
    
    public function __construct(Connection $oAdapter, $sResultTableName)
    {
        $this->oAdapter = $oAdapter;
        $this->sResultTableName = $sResultTableName;
    }
    
    
    /**
     * Start the complier
     * 
     * @access public
     * @return void
     * @param ComplileResult    $oResult
     * @param DateTime          $oProcessingDate
     */ 
    public function execute(ComplileResult $oResult, DateTime $oProcessingDate)
    {
        $this->oLastResult = $oResult;
        
        try {
            
            // Execute Each Pass
            
            foreach($this->aPasses as $oPass) {
                $oPass->execute($sResultTableName,$oProcessingDate);
            }
            
            // fetch the results
            
            
            
            
        } catch(PointsMachineException $e) {
            
            
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
     * Add a pass to this complier, passes will be executed in 
     * the order they are added.
     * 
     * @param CompilerPassInterface $oPass  the pass to add.
     * @return void
     * 
     */ 
    public function addPass(CompilerPassInterface $oPass)
    {
        $this->aPasses[] = $oPass;
    }
    
    /**
     * Return the complied result as collection.
     * 
     * @access public
     * @return Doctrine\Common\Collection
     */ 
    public function getResult()
    {
        return $this->oLastResult;
    }
    
    /**
     * Temp table that will hold the results at the start and the finish
     * though each pass may use their own temp tables
     * 
     * @access public
     * @return string the table name 
     */ 
    public function getResultTableName()
    {
        return $this->sResultTableName;
    }
    
}