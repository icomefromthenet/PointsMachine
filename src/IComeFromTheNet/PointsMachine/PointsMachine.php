<?php
namespace IComeFromTheNet\PointsMachine;

use Exception;
use DateTime;
use IComeFromTheNet\PointsMachine\PointsMachineContainer;


class PointsMachine
{
    /**
     * @var IComeFromTheNet\PointsMachine\PointsMachineContainer 
     */ 
    protected $oContainer;
    
    /**
     * @var string the guid of the event type.
     */ 
    protected $sEventTypeId;
    
    /**
     * @var DateTime
     */ 
    protected $oProcessingDate;
    
    /**
     * @var array
     */ 
    protected $aScores;
    
    /**
     * @var array
     */ 
    protected $aAdjustmentRules;
    
    /**
     * @var string The Database table id pt_system
     */ 
    protected $sPointSystemId;
    
    /**
     * @var string The Database table id pt_system_zone
     */ 
    protected $sPointSystemZoneId;
    
   /**
    * @var integer the event instance id
    */ 
    protected $iEventInstanceId;
    
    /**
     * Return this libs container
     * 
     * @return IComeFromTheNet\PointsMachine\PointsMachineContainer
     * 
     */ 
    protected function getContainer()
    {
        return $this->oContainer;        
    }
    
    
    protected function seedTmpTables()
    {
        $oContainer        = $this->getContainer();     
        $oDatabase         = $oContainer->getDatabaseAdaper();
        $oTmpScoreGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_score');
        $oTmpRuleGateway   = $oContainer->getGatewayCollection()->getGateway('pt_result_rule');
        
        # Create the tmp tables
        $oTmpScoreGateway->getTableMaker()->createTable();
        $oTmpRuleGateway->getTableMaker()->createTable();
        
        # insert score seeds
        foreach($this->aScores as $sScore) {
            
            $bSuccess = $oTmpScoreGateway->insertQuery()
             ->start()
                ->addColumn('score_id',$sScore)
                
             ->end()
            ->insert(); 
    
            if(!$bSuccess) {
                throw new PointsMachineException('Unable to insert score seed');
            }
                
            
        }
        
        
        # insert Adj Rules Seeds
        foreach($this->aAdjustmentRules as $sAdjustmentRuleId) {
        
             $bSuccess = $oTmpRuleGateway->insertQuery()
             ->start()
                ->addColumn('rule_id',$sAdjustmentRuleId)
                
             ->end()
            ->insert(); 
    
            if(!$bSuccess) {
                throw new PointsMachineException('Unable to insert adjustment rule seed');
            }
            
        }
        
        
        
        
    }
    
    /**
     * Generate an event Instance
     * 
     * @return void
     * @access protected
     */ 
    protected function generateEventInstance()
    {
        
    }
    
    
    public function __construct(PointsMachineContainer $oContainer)
    {
        $this->oContainer   = $oContainer;
        
    }
    
    
    //---------------------------------------------------------------
    # Operations
    
    /**
     * Clears any state ready for a new calculation round
     *  
     * @return void;
     */ 
    public function newRound()
    {
        $this->oProcessingDate  = null;
        $this->sEventTypeId     = null;
        $this->sPointSystemId    = null;
        $this->sPointSystemZoneId = null;
        $this->aScores          = array();
        $this->aAdjustmentRules = array();
        $this->iEventInstanceId = null;
        
        
    }

    public function executeRound()
    {
        
        # verify the necessary params
        
        
        # generate and instance
        $this->generateEventInstance();
        
        
        # seed result table
        $this->seedTmpTables();
        
        
        # execute the calculator complier
        
        
    }

    /**
     * Add a score to process in this round.
     * 
     * @param   string  $sScoreId           The database table id of pt_score
     * @return void
     */ 
    public function addScore($sScoreId)
    {
        if(true === empty($sScoreId)) {
            throw new PointsMachineException('The ScoreId must not be empty');
        }
        
        $this->aScores[] = $sScoreId;
    }

    /**
     * Add an Adjustment rule to maybe be used in this round.
     * 
     * Not all rules may be applied to every score.
     * 
     * @param string    $sAdjustmentRuleId  The Database table id for the entity at table pt_rule
     * @return void
     */ 
    public function addAdjustmentRules($sAdjustmentRuleId)
    {
        
        if(true === empty($sAdjustmentRuleId)) {
            throw new PointsMachineException('The AdjustmentRuleId must not be empty');
        }
        
        $this->aAdjustmentRules[$sAdjustmentRuleId] = $sAdjustmentRuleId;
    }


    // --------------------------------------------------------------
    # Public Properties
    
    /**
     * Set the Event Type for the Round
     *  
     * @param string $sEventTypeId Entity Id from the database table pt_event_type
     * @return void
     */ 
    public function setEventType($sEventTypeId)
    {
        if(true === empty($sEventTypeId)) {
            throw new PointsMachineException('The Event Type Id must not be empty');
        }
        
        $this->sEventTypeId = $sEventTypeId;
    }
    
    /**
     * Set the date to be considered NOW(), used to identify which version of
     * the various entities will be used.
     * 
     * @param DateTime $oProcessingDate
     * @return void
     */ 
    public function setProcessingDate(DateTime $oProcessingDate)
    {
        $this->oProcessingDate = $oProcessingDate;
    }
    
    /**
     * Sets the Point System to use
     * 
     * @return void
     * @param   string  $sPointSystemId     The Database table id pt_system
     */ 
    public function setPointSystem($sPointSystemId)
    {
        if(true === empty($sPointSystemId)) {
            throw new PointsMachineException('The PointsSystemId must not be empty');
        }
        
        $this->sPointSystemId = $sPointSystemId;        
    }
    
    /**
     * Sets the Point System Zone to use
     * 
     * @param   string  $sPointSystemZoneId Optional The Database id table zone_id
     * @return boid
     */
    public function setPointSystemZone($sPointSystemZoneId)
    {
        $this->sPointSystemZoneId = $sPointSystemZoneId;
    }
    
}
/* End of File */