<?php
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



return function($oPointsContainer) {
  
  $oDatabase = $oPointsContainer->getDatabaseAdaper();  
  $oSystemGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_system');
  $oLogger        = $oPointsContainer->getAppLogger();
  
  
  
  
  $oDatabase->beginTransaction();
  
  
  // Create the System 
  
  $oPointSystem = new PointSystem($oSystemGateway,$oLogger);
  
  $oPointSystem->sSystemID       = $oPointSystem->guid();
  $oPointSystem->sSystemName     = 'Simple Discount';
  $oPointSystem->sSystemNameSlug = 'simple_discount';
  
  $bResult = $oPointSystem->save();
  $aLastResult = $oPointSystem->getLastQueryResult();
  
  if(false === $bResult) {
    throw new \RuntimeException($aLastResult['msg']);
  }
  
  // Create some SystemZones
  
  $oSystemZoneGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_system_zone');
  
  
  $oPriestZone  = new PointSystemZone($oSystemZoneGateway,$oLogger);
  $oWarriorZone = new PointSystemZone($oSystemZoneGateway,$oLogger);
  $oMageZone    = new PointSystemZone($oSystemZoneGateway,$oLogger);
  
  $oPriestZone->sZoneID       = $oPriestZone->guid();
  $oPriestZone->sSystemID     = $oPointSystem->sSystemID;
  $oPriestZone->sZoneName     = 'Priest Class';
  $oPriestZone->sZoneNameSlug = 'priest_class';
  
  $oWarriorZone->sZoneID       = $oPriestZone->guid();
  $oWarriorZone->sSystemID     = $oPointSystem->sSystemID;
  $oWarriorZone->sZoneName     = 'Warrior Class';
  $oWarriorZone->sZoneNameSlug = 'warrior_class';
  
  $oMageZone->sZoneID       = $oPriestZone->guid();
  $oMageZone->sSystemID     = $oPointSystem->sSystemID;
  $oMageZone->sZoneName     = 'Mage Class';
  $oMageZone->sZoneNameSlug = 'mage_class';
  
  foreach(array($oPriestZone,$oWarriorZone,$oMageZone) as $oZone) {
    
    $bResult = $oZone->save();
    $aLastResult = $oZone->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oZone->sZoneName .' '.$aLastResult['msg']);
    }
    
  }
  
  // Create events 
   
  $oEventTypeGateway =  $oPointsContainer->getGatewayCollection()->getGateway('pt_event_type');
    
  $oDungeonRaidEventType  = new EventType($oEventTypeGateway,$oLogger);  
  $oOutdoorRaidEventType = new EventType($oEventTypeGateway,$oLogger);  
  $oPVPRaidEventType     = new EventType($oEventTypeGateway,$oLogger);  
  $oDonationEventType    = new EventType($oEventTypeGateway,$oLogger);
   
  $oDungeonRaidEventType->sEventTypeID  = $oDungeonRaidEventType->guid();
  $oDungeonRaidEventType->sEventName    = 'Dungeon Raid';
  $oDungeonRaidEventType->sEventNameSlug = 'dungeon_raid';
  
  $oOutdoorRaidEventType->sEventTypeID  = $oOutdoorRaidEventType->guid();
  $oOutdoorRaidEventType->sEventName    = 'Outdoor Raid';
  $oOutdoorRaidEventType->sEventNameSlug = 'outdoor_raid';
  
  $oPVPRaidEventType->sEventTypeID  = $oPVPRaidEventType->guid();
  $oPVPRaidEventType->sEventName    = 'PVP Raid';
  $oPVPRaidEventType->sEventNameSlug = 'pvp_raid';
  
  $oDonationEventType->sEventTypeID  = $oDonationEventType->guid();
  $oDonationEventType->sEventName    = 'Bank Donation';
  $oDonationEventType->sEventNameSlug = 'bank_donation';
  
  
  foreach(array($oDungeonRaidEventType,$oOutdoorRaidEventType,$oPVPRaidEventType,$oDonationEventType) as $oEventType) {
    
    $bResult = $oEventType->save();
    $aLastResult = $oEventType->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oEventType->sEventName .' '.$aLastResult['msg']);
    }
    
  }
  
  // Define some scores and groups
  
  $oScoreGroupGateway =  $oPointsContainer->getGatewayCollection()->getGateway('pt_score_group');
  
    
  $oPVEScoreGroup      = new ScoreGroup($oScoreGroupGateway,$oLogger); 
  $oPVPScoreGroup      = new ScoreGroup($oScoreGroupGateway,$oLogger);
  $oDonationScoreGroup = new ScoreGroup($oScoreGroupGateway,$oLogger);
  
  $oPVEScoreGroup->sScoreGroupID = $oPVEScoreGroup->guid();
  $oPVEScoreGroup->sGroupName    = 'PVE Score Group';
  $oPVEScoreGroup->sGroupNameSlug = 'pve_score_group';
  
  $oPVPScoreGroup->sScoreGroupID = $oPVPScoreGroup->guid();
  $oPVPScoreGroup->sGroupName    = 'PVP Score Group';
  $oPVPScoreGroup->sGroupNameSlug = 'pvp_score_group';
  
  $oDonationScoreGroup->sScoreGroupID = $oDonationScoreGroup->guid();
  $oDonationScoreGroup->sGroupName    = 'Donations Score Group';
  $oDonationScoreGroup->sGroupNameSlug = 'donations_score_group';
  
  foreach(array($oPVEScoreGroup,$oPVPScoreGroup,$oDonationScoreGroup) as $oScoreGroup) {
    
    $bResult = $oScoreGroup->save();
    $aLastResult = $oScoreGroup->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oScoreGroup->sGroupName .' '.$aLastResult['msg']);
    }
    
  }
  
  // Define some scores and score groups
  $oScoreGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_score');
  

  
  $oLargeDonationScore   = new Score($oScoreGateway,$oLogger);
  $oSmallDonationScore   = new Score($oScoreGateway,$oLogger);
  $oAverageDonationScore = new Score($oScoreGateway,$oLogger);
  $oDungeon5ManScore      = new Score($oScoreGateway,$oLogger);
  $oDungeon10ManScore     = new Score($oScoreGateway,$oLogger);
  $oDungeon20ManScore     = new Score($oScoreGateway,$oLogger);
  $oPVPParticipationScore = new Score($oScoreGateway,$oLogger);
  
  $oLargeDonationScore->sScoreID        = $oLargeDonationScore->guid();
  $oLargeDonationScore->sScoreGroupID   = $oDonationScoreGroup->sScoreGroupID;
  $oLargeDonationScore->sScoreName      = 'Large Donations';
  $oLargeDonationScore->sScoreNameSlug  = 'large_donations';
  $oLargeDonationScore->fScoreValue     = 20;
  
  $oSmallDonationScore->sScoreID        = $oSmallDonationScore->guid();
  $oSmallDonationScore->sScoreGroupID   = $oDonationScoreGroup->sScoreGroupID;
  $oSmallDonationScore->sScoreName      = 'Small Donations';
  $oSmallDonationScore->sScoreNameSlug  = 'small_donations';
  $oSmallDonationScore->fScoreValue     = 5;
  
  $oAverageDonationScore->sScoreID        = $oAverageDonationScore->guid();
  $oAverageDonationScore->sScoreGroupID   = $oDonationScoreGroup->sScoreGroupID;
  $oAverageDonationScore->sScoreName      = 'Average Donations';
  $oAverageDonationScore->sScoreNameSlug  = 'average_donations';
  $oAverageDonationScore->fScoreValue     = 10;
  
  $oDungeon5ManScore->sScoreID        = $oDungeon5ManScore->guid();
  $oDungeon5ManScore->sScoreGroupID   = $oPVEScoreGroup->sScoreGroupID;
  $oDungeon5ManScore->sScoreName      = '5 Man Dungeon';
  $oDungeon5ManScore->sScoreNameSlug  = '5_man_dungeon';
  $oDungeon5ManScore->fScoreValue     = 5;
  
  $oDungeon10ManScore->sScoreID        = $oDungeon10ManScore->guid();
  $oDungeon10ManScore->sScoreGroupID   = $oPVEScoreGroup->sScoreGroupID;
  $oDungeon10ManScore->sScoreName      = '10 Man Dungeon';
  $oDungeon10ManScore->sScoreNameSlug  = '10_man_dungeon';
  $oDungeon10ManScore->fScoreValue     = 20;
  
  
  $oDungeon20ManScore->sScoreID       = $oDungeon20ManScore->guid();
  $oDungeon20ManScore->sScoreGroupID   = $oPVEScoreGroup->sScoreGroupID;
  $oDungeon20ManScore->sScoreName      = '20 Man Dungeon';
  $oDungeon20ManScore->sScoreNameSlug  = '20_man_dungeon';
  $oDungeon20ManScore->fScoreValue     = 20;
  
  $oPVPParticipationScore->sScoreID       = $oPVPParticipationScore->guid();
  $oPVPParticipationScore->sScoreGroupID   = $oPVPScoreGroup->sScoreGroupID;
  $oPVPParticipationScore->sScoreName      = 'PVP Participation';
  $oPVPParticipationScore->sScoreNameSlug  = 'pvp_participation';
  $oPVPParticipationScore->fScoreValue     = 15;
    
    
  foreach(array($oLargeDonationScore,   
                $oSmallDonationScore,   
                $oAverageDonationScore, 
                $oDungeon5ManScore,     
                $oDungeon10ManScore,    
                $oDungeon20ManScore,    
                $oPVPParticipationScore ) as $oScore) {
                  
    $bResult = $oScore->save();
    $aLastResult = $oScore->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oScore->sScoreName .' '.$aLastResult['msg']);
    }
    
  } 
  
  // Define the donation forumla 
  
  $oAdjGroupGateway       = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_group');
  $oAdjRuleGateway        = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule');
  $oRuleChainGateway      = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_chain');
  $oChainMemberGateway    = $oPointsContainer->getGatewayCollection()->getGateway('pt_chain_member');
  $oAdjRuleZones          = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_sys_zone');
  $oAdjGroupLimitsGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
  
  
  // The Class Difficulty Modifer Group
  $oClassDifficultyAdjGroup                     = new AdjustmentGroup($oAdjGroupGateway,$oLogger);
   
  $oClassDifficultyAdjGroup->sAdjustmentGroupID = $oClassDifficultyAdjGroup->guid();
  $oClassDifficultyAdjGroup->sGroupName         = 'Class Difficulty Group';
  $oClassDifficultyAdjGroup->sGroupNameSlug     = 'class_difficulty_group';
  
  // These settings ensure only 1 modifer is used from this group and will be the largest
  $oClassDifficultyAdjGroup->iMaxCount          = 1; 
  $oClassDifficultyAdjGroup->iOrderMethod       = AdjustmentGroup::ORDER_HIGHT;
  
  // This will ensure that all modifers are included in the calculation run (filtered out by system zones)
  $oClassDifficultyAdjGroup->bIsMandatory       = true;
  
  
  // Donation Demand Modifier Group
  $oDonationDemandAdjGroup                     = new AdjustmentGroup($oAdjGroupGateway,$oLogger);
  
  $oDonationDemandAdjGroup->sAdjustmentGroupID = $oDonationDemandAdjGroup->guid();
  $oDonationDemandAdjGroup->sGroupName         = 'Donation Demand Group';
  $oDonationDemandAdjGroup->sGroupNameSlug     = 'donation_demand_group';
  
  // Only those adjustment rules applied will be used.
  $oDonationDemandAdjGroup->bIsMandatory       = false;
  
  
  // Save the groups
  
  foreach(array($oClassDifficultyAdjGroup,$oDonationDemandAdjGroup   
                ) as $oAdjGroup) {
                  
    $bResult = $oAdjGroup->save();
    $aLastResult = $oAdjGroup->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oAdjGroup->sGroupName .' '.$aLastResult['msg']);
    }
    
  } 
  
  
  // Create the Rules
  
  $oHealerAdjRule       = new AdjustmentRule($oAdjRuleGateway,$oLogger);
  $oMeeleeAdjRule       = new AdjustmentRule($oAdjRuleGateway,$oLogger);
  $oCasterAdjRule       = new AdjustmentRule($oAdjRuleGateway,$oLogger);
  
  $oHeavyDemandAdjRule  = new AdjustmentRule($oAdjRuleGateway,$oLogger);
  $oLowDemandAdjRule    = new AdjustmentRule($oAdjRuleGateway,$oLogger);
  $oAverageDemandAdjRule = new AdjustmentRule($oAdjRuleGateway,$oLogger);
  
  
  
  $oHealerAdjRule->sAdjustmentRuleID   = $oHealerAdjRule->guid();
  $oHealerAdjRule->sAdjustmentGroupID  = $oClassDifficultyAdjGroup->sAdjustmentGroupID;
  $oHealerAdjRule->sRuleName           = 'Healer Difficulty Rule';
  $oHealerAdjRule->sRuleNameSlug       = 'header_difficulty_rule';
  $oHealerAdjRule->fMultiplier         =  1.3; 
  
  $oMeeleeAdjRule->sAdjustmentRuleID   = $oMeeleeAdjRule->guid();
  $oMeeleeAdjRule->sAdjustmentGroupID  = $oClassDifficultyAdjGroup->sAdjustmentGroupID;
  $oMeeleeAdjRule->sRuleName           = 'Meelee Difficulty Rule';
  $oMeeleeAdjRule->sRuleNameSlug       = 'meelee_difficulty_rule';
  $oMeeleeAdjRule->fMultiplier         =  1.1; 
  
  
  $oCasterAdjRule->sAdjustmentRuleID   = $oCasterAdjRule->guid();
  $oCasterAdjRule->sAdjustmentGroupID  = $oClassDifficultyAdjGroup->sAdjustmentGroupID;
  $oCasterAdjRule->sRuleName           = 'Caster Difficulty Rule';
  $oCasterAdjRule->sRuleNameSlug       = 'caster_difficulty_rule';
  $oCasterAdjRule->fMultiplier         =  0.8; 
  
  
  $oHeavyDemandAdjRule->sAdjustmentRuleID   = $oHeavyDemandAdjRule->guid();
  $oHeavyDemandAdjRule->sAdjustmentGroupID  = $oDonationDemandAdjGroup->sAdjustmentGroupID;
  $oHeavyDemandAdjRule->sRuleName           = 'Heavy Demand Rule';
  $oHeavyDemandAdjRule->sRuleNameSlug       = 'heavy_demand_rule';
  $oHeavyDemandAdjRule->fMultiplier         =  1.5; 
  
  
  
  $oLowDemandAdjRule->sAdjustmentRuleID   = $oLowDemandAdjRule->guid();
  $oLowDemandAdjRule->sAdjustmentGroupID  = $oDonationDemandAdjGroup->sAdjustmentGroupID;
  $oLowDemandAdjRule->sRuleName           = 'Low Demand Rule';
  $oLowDemandAdjRule->sRuleNameSlug       = 'low_demand_rule';
  $oLowDemandAdjRule->fMultiplier         =  0.8; 
  
  
  $oAverageDemandAdjRule->sAdjustmentRuleID   = $oAverageDemandAdjRule->guid();
  $oAverageDemandAdjRule->sAdjustmentGroupID  = $oDonationDemandAdjGroup->sAdjustmentGroupID;
  $oAverageDemandAdjRule->sRuleName           = 'Average Demand Rule';
  $oAverageDemandAdjRule->sRuleNameSlug       = 'average_demand_rule';
  $oAverageDemandAdjRule->fMultiplier         =  1.15; 
  
  
   
  foreach(array($oHealerAdjRule,$oMeeleeAdjRule,$oCasterAdjRule,$oHeavyDemandAdjRule,$oLowDemandAdjRule,$oAverageDemandAdjRule) as $oAdjRule) {
                  
    $bResult = $oAdjRule->save();
    $aLastResult = $oAdjRule->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oAdjRule->sRuleName .' '.$aLastResult['msg']);
    }
    
  } 
  
  // Link rules to their System Zones
  $oPriestAdjRuleZone   = new AdjustmentZone($oAdjRuleZones,$oLogger);
  $oWarriorAdjRuleZone  = new AdjustmentZone($oAdjRuleZones,$oLogger);
  $oMageAdjRuleZone     = new AdjustmentZone($oAdjRuleZones,$oLogger);


  
  $oPriestAdjRuleZone->sAdjustmentRuleID = $oHealerAdjRule->sAdjustmentRuleID;
  $oPriestAdjRuleZone->sSystemZoneID     = $oPriestZone->sZoneID;
    
  $oWarriorAdjRuleZone->sAdjustmentRuleID = $oMeeleeAdjRule->sAdjustmentRuleID;
  $oWarriorAdjRuleZone->sSystemZoneID     = $oWarriorZone->sZoneID;
  
  $oMageAdjRuleZone->sAdjustmentRuleID    = $oCasterAdjRule->sAdjustmentRuleID;
  $oMageAdjRuleZone->sSystemZoneID        = $oMageZone->sZoneID;
    
  
  foreach(array($oPriestAdjRuleZone) as $oAdjRuleZone) {
                  
    $bResult = $oAdjRuleZone->save();
    $aLastResult = $oAdjRuleZone->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oAdjRuleZone->sAdjustmentRuleID .' '.$oAdjRuleZone->sZoneID.' '. $aLastResult['msg']);
    }
    
  } 
  
  // Create Rule Chain
  
  $oDonationRuleChain = new RuleChain($oRuleChainGateway,$oLogger);
  
  $oDonationRuleChain->sRuleChainID = $oDonationRuleChain->guid();
  $oDonationRuleChain->sEventTypeID = $oDonationEventType->sEventTypeID;
  $oDonationRuleChain->sSystemID    = $oPointSystem->sSystemID;    
  $oDonationRuleChain->sChainName   = 'Donations Chain';
  $oDonationRuleChain->sChainNameSlug = 'donations_chain';
  $oDonationRuleChain->iRoundingOption = RuleChain::ROUND_CEIL;
  $oDonationRuleChain->fCapValue    = 500;
    
    
    
  foreach(array($oDonationRuleChain) as $oRuleChain) {
                  
    $bResult = $oRuleChain->save();
    $aLastResult = $oRuleChain->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oRuleChain->sChainName .' '. $aLastResult['msg']);
    }
    
  } 
  
  // Create Some Chain Members
  $oClassDifficultyMember = new RuleChainMember($oChainMemberGateway,$oLogger);
  $oDemandBonusMember     = new RuleChainMember($oChainMemberGateway,$oLogger);
  
  
  $oClassDifficultyMember->sRuleChainMemberID = $oClassDifficultyMember->guid();
  $oClassDifficultyMember->sRuleChainID       = $oDonationRuleChain->sRuleChainID;
  $oClassDifficultyMember->sAdjustmentGroupID = $oClassDifficultyAdjGroup->sAdjustmentGroupID;
  $oClassDifficultyMember->iOrderSeq          = 1;
  
  $oDemandBonusMember->sRuleChainMemberID = $oDemandBonusMember->guid();
  $oDemandBonusMember->sRuleChainID       = $oDonationRuleChain->sRuleChainID;
  $oDemandBonusMember->sAdjustmentGroupID = $oDonationDemandAdjGroup->sAdjustmentGroupID;
  $oDemandBonusMember->iOrderSeq          = 2;
  
  
  foreach(array($oClassDifficultyMember,$oDemandBonusMember) as $oRuleChainMember) {
                  
    $bResult = $oRuleChainMember->save();
    $aLastResult = $oRuleChainMember->getLastQueryResult();
  
    if(false === $bResult) {
      throw new \RuntimeException($oRuleChainMember->sRuleChainMemberID .' '. $aLastResult['msg']);
    }
    
    
  } 
  
  // Save the results
  
  $oDatabase->commit();
  
  $oDatabase->beginTransaction();
  
  
  // Do a Donation Calculation Run
  $oPointsMachineCal = new PointsMachine($oPointsContainer);
  
  $oPointsMachineCal->newRound();
  
  
  // Set Run Details
  
  $oPointsMachineCal->setProcessingDate(new \DateTime('now'));
  $oPointsMachineCal->setPointSystem($oPointSystem->sSystemID);
  $oPointsMachineCal->setPointSystemZone($oPriestZone->sZoneID);
  $oPointsMachineCal->setOccuredDate(new \DateTime('now'));
  $oPointsMachineCal->setEventType($oDonationEventType->sEventTypeID);
  
  // Set Rule and Score Details
  
  for($i=0; $i<10; $i++) {
    $oPointsMachineCal->addScore($oLargeDonationScore->sScoreID);
  }
  
  
  
  $oPointsMachineCal->addAdjustmentRule($oHeavyDemandAdjRule->sAdjustmentRuleID);
  
  $aResult = $oPointsMachineCal->executeRound();
  
  
  $oDatabase->commit();
  
  
};

