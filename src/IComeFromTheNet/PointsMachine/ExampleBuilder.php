<?php
namespace IComeFromTheNet\PointsMachine;

use RuntimeException;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystem;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystemZone;
use IComeFromTheNet\PointsMachine\DB\Entity\EventType;
use IComeFromTheNet\PointsMachine\DB\Entity\ScoreGroup;
use IComeFromTheNet\PointsMachine\DB\Entity\Score;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentRule;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroup;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroupLimit;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentZone;
use IComeFromTheNet\PointsMachine\DB\Entity\RuleChain;
use IComeFromTheNet\PointsMachine\DB\Entity\RuleChainMember;
use IComeFromTheNet\PointsMachine\PointsMachine;


class ExampleBuilder 
{
    
    /**
     * @var IComeFromTheNet\PointsMachine\PointsMachineContainer
     */ 
    protected $oContainer;
    
    /**
     * @var IComeFromTheNet\PointsMachine\DB\Entity\PointSystem
     */ 
    protected $oSystem;
    
    /**
     * @var array[IComeFromTheNet\PointsMachine\DB\Entity\PointSystemZone]
     */  
    protected $aZones;
    
    /**
    * @var array[IComeFromTheNet\PointsMachine\DB\Entity\EventType]
    */
    protected $aEvents;
    
    /**
    * @var array[IComeFromTheNet\PointsMachine\DB\Entity\ScoreGroup]
    */
    protected $aScoreGroups;
    
    /**
     * @var array[IComeFromTheNet\PointsMachine\DB\Entity\Score] 
     */
    protected $aScores;
    
    /**
     * @var array[IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroup] 
     */ 
    protected $aAdjGroups;
    
    /**
     * @var array[IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentRule] 
     */ 
    protected $aAdjRules;
    
    
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        // trim
        $text = trim($text, '-');
        
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        
        // lowercase
        $text = strtolower($text);
        
        if (empty($text)) {
        return 'n-a';
        }
        
        return $text;
    }
    
    
    
    public function __construct(PointsMachineContainer $oContainer)
    {
        $this->oContainer = $oContainer;
    }
    
    
    
    public function createSystem($sSystemName)
    {
        $oPointsContainer = $this->oContainer;
        
        $oDatabase      = $oPointsContainer->getDatabaseAdaper();  
        $oSystemGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger        = $oPointsContainer->getAppLogger();
        
        
        
        
        $oDatabase->beginTransaction();
        
        
        // Create the System 
        
        $oPointSystem = new PointSystem($oSystemGateway,$oLogger);
        
        $oPointSystem->sSystemID       = $oPointSystem->guid();
        $oPointSystem->sSystemName     = $sSystemName;
        $oPointSystem->sSystemNameSlug = $this->slugify($sSystemName);
        
        $bResult = $oPointSystem->save();
        $aLastResult = $oPointSystem->getLastQueryResult();
        
        if(false === $bResult) {
            throw new \RuntimeException($aLastResult['msg']);
        }
        
        // Bind to internal collection
        $this->oSystem = $oPointSystem;
        
    }
    
    
    public function commitSystem()
    {
        $oPointsContainer = $this->oContainer;
        
        $oDatabase      = $oPointsContainer->getDatabaseAdaper();  
        
        if(empty($this->aEvents)) {
            throw new RuntimeException('System must have at least 1 event');
        }
        
        if(empty($this->aScores)) {
            throw new RuntimeException('System must have at least 1 score');
        }
        
        
        if(empty($this->aAdjGroups)) {
            throw new RuntimeException('System must have at least 1 Adjustment Group');
        }
        
        if(empty($this->aAdjRules)) {
            throw new RuntimeException('System must have at least 1 Adjustment Rule');
        }
        
        
        
        $oDatabase->commit();

    }
    
    
    
    public function addSystemZone($sZoneName)
    {
        
        if(true === empty($this->oSystem)) {
            throw new RuntimeException('A System must be created first');
        }
        
        $oPointsContainer   = $this->oContainer;
        $oSystemZoneGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger            = $oPointsContainer->getAppLogger();
        
        $oZone  = new PointSystemZone($oSystemZoneGateway,$oLogger);
        
        $oZone->sZoneID       = $oZone->guid();
        $oZone->sSystemID     = $this->oSystem->sSystemID;
        $oZone->sZoneName     = $sZoneName;
        $oZone->sZoneNameSlug = $this->slugify($sZoneName);
  
    
        $bResult = $oZone->save();
        $aLastResult = $oZone->getLastQueryResult();
        
        if(false === $bResult) {
          throw new \RuntimeException($oZone->sZoneName .' '.$aLastResult['msg']);
        }
        
        // Add Zone to Interal Collection
        $this->aZones[$oZone->sZoneNameSlug] = $oZone;
        
    }
    
    
    
   public function addEvent($sEventName) 
   {
       
        $oEventTypeGateway  = $this->oContainer->getGatewayCollection()->getGateway('pt_event_type');
        $oLogger            = $this->oContainer->getAppLogger();
        
        $oEventType  = new EventType($oEventTypeGateway,$oLogger);  
        
        
        $oEventType->sEventTypeID  = $oDungeonRaidEventType->guid();
        $oEventType->sEventName    = $sEventName;
        $oEventType->sEventNameSlug = $this->slugify($sEventName);
    
        $bResult = $oEventType->save();
        $aLastResult = $oEventType->getLastQueryResult();
        
        if(false === $bResult) {
          throw new \RuntimeException($oEventType->sEventName .' '.$aLastResult['msg']);
        }
    
        // Assign to internal collection
        $this->aEvents[$oEventType->sEventNameSlug] = $oEventType;
       
   }
   
   
   
    public function addScoringGroup($sGroupName)
    {
      
        // Define some scores and groups
        
        $oScoreGroupGateway =  $this->oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $oLogger            = $this->oContainer->getAppLogger();
        
        $oScoreGroup      = new ScoreGroup($oScoreGroupGateway,$oLogger); 
       
        $oScoreGroup->sScoreGroupID = $oPVEScoreGroup->guid();
        $oScoreGroup->sGroupName    = $sGroupName;
        $oScoreGroup->sGroupNameSlug = $this->slugify($sGroupName);
        
        
        $bResult = $oScoreGroup->save();
        $aLastResult = $oScoreGroup->getLastQueryResult();
        
        if(false === $bResult) {
          throw new \RuntimeException($oScoreGroup->sGroupName .' '.$aLastResult['msg']);
        }
        
        // Assign to internal collection
        $this->aScoreGroups[$oScoreGroup->sGroupNameSlug] = $oScoreGroup;
       
    }



    public function addScrore($sScoreName, $fScoreValue, $sScoreGroupNameSlug)
    {
        
        if(!isset($this->aScoreGroups[$sScoreGroupNameSlug])) {
            throw new RuntimeException('The score gorup'.$sScoreGroupNameSlug.' does not exist');
        }
        
        $oScoreGateway  = $this->oContainer->getGatewayCollection()->getGateway('pt_score');
        $oLogger        = $this->oContainer->getAppLogger();
        
        
        $oScore   = new Score($oScoreGateway,$oLogger);
        
        
        $oScore->sScoreID        = $oScore->guid();
        $oScore->sScoreGroupID   = $this->aScoreGroups[$sScoreGroupNameSlug]->sScoreGroupID;
        $oScore->sScoreName      = $sScoreName;
        $oScore->sScoreNameSlug  = $this->slugify($sScoreName);
        $oScore->fScoreValue     = $fScoreValue;
        
        $bResult     = $oScore->save();
        $aLastResult = $oScore->getLastQueryResult();
        
        if(false === $bResult) {
            throw new RuntimeException($oScore->sScoreName .' '.$aLastResult['msg']);
        }

        $this->aScores[$oScore->sScoreNameSlug] = $oScore;
        
    }
    
    
    
    public function addAdjustmentGroup($sGroupName, $iMaxCount, $iOrderMethod, $bMandatory)
    {
        
        $oAdjGroupGateway    = $this->oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        $oLogger             = $this->oContainer->getAppLogger();
        
        
        $oAdjGroup                     = new AdjustmentGroup($oAdjGroupGateway,$oLogger);
        
        $oAdjGroup->sAdjustmentGroupID = $oAdjGroup->guid();
        $oAdjGroup->sGroupName         = $sGroupName;
        $oAdjGroup->sGroupNameSlug     = $this->slugify($sGroupName);
        
        // These settings ensure only x modifers is used from this group and will be the largest
        $oAdjGroup->iMaxCount          = $iMaxCount; 
        $oAdjGroup->iOrderMethod       = $iOrderMethod;
        
        // This will ensure that all modifers are included in the calculation run (filtered out by system zones)
        $oAdjGroup->bIsMandatory       = $bMandatory;
        
        $bResult = $oAdjGroup->save();
        $aLastResult = $oAdjGroup->getLastQueryResult();
        
        if(false === $bResult) {
            throw new \RuntimeException($oAdjGroup->sGroupName .' '.$aLastResult['msg']);
        }
 
        // Add Group to internal collection
        $this->aAdjGroups[$oAdjGroup->sGroupNameSlug] = $oAdjGroup;
        
    }
    
    
    
    public function addAdjustmentRuleWithMultiplier($sRuleName, $fMultiplier)
    {
        
        $oAdjRuleGateway     = $this->oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger             = $this->oContainer->getAppLogger();
        
        $oRule       = new AdjustmentRule($oAdjRuleGateway,$oLogger);
        
        
        $oRule->sAdjustmentRuleID   = $oRule->guid();
        $oRule->sAdjustmentGroupID  = $oClassDifficultyAdjGroup->sAdjustmentGroupID;
        $oRule->sRuleName           = $sRuleName;
        $oRule->sRuleNameSlug       = $this->slugify($sRuleName);
        $oRule->fMultiplier         = $fMultiplier; 
        $oRule->bInvertFlag         = false;
        
        
        
        
    }
    
    public function addAdjustmentRuleWithDivisior($sRuleName, $fDivisor)
    {
        
        $oAdjRuleGateway     = $this->oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger             = $this->oContainer->getAppLogger();
        
        $oRule       = new AdjustmentRule($oAdjRuleGateway,$oLogger);
        
        
        $oRule->sAdjustmentRuleID   = $oRule->guid();
        $oRule->sAdjustmentGroupID  = $oClassDifficultyAdjGroup->sAdjustmentGroupID;
        $oRule->sRuleName           = $sRuleName;
        $oRule->sRuleNameSlug       = $this->slugify($sRuleName);
        $oRule->fMultiplier         = $fDivisor; 
        $oRule->bInvertFlag         = true;
        
        
    }
    
    
    
    
    public function addAdjustmentRuleWithPositiveModifier($sRuleName, $fModifier)
    {
        
        
        
    }
    
    
    
    public function addAdjustmentRuleWithNegativeModifier($sRuleName, $fModifier)
    {
        
        
        
    }
    
    
    
    
    
    
    
}
/* End of Class */