<?php
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystem;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystemZone;
use IComeFromTheNet\PointsMachine\DB\Entity\EventType;
use IComeFromTheNet\PointsMachine\DB\Entity\ScoreGroup;
use IComeFromTheNet\PointsMachine\DB\Entity\Score;



return function($oPointsContainer) {
    
  $oSystemGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_system');
  $oLogger        = $oPointsContainer->getAppLogger();
  
  // Create the System 
  
  $oPointSystem = new PointSystem($oSystemGateway,$oLogger);
  
  $oPointSystem->sSystemID       = $oPointSystem->guid();
  $oPointSystem->sSystemName     = 'Raid Calculator';
  $oPointSystem->sSystemNameSlug = 'raid_calculator';
  
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
  
   
  $oDungeonRaidEventType->sEventTypeID  = $oDungeonRaidEventType->guid();
  $oDungeonRaidEventType->sEventName    = 'Dungeon Raid';
  $oDungeonRaidEventType->sEventNameSlug = 'dungeon_raid';
  
  $oOutdoorRaidEventType->sEventTypeID  = $oOutdoorRaidEventType->guid();
  $oOutdoorRaidEventType->sEventName    = 'Outdoor Raid';
  $oOutdoorRaidEventType->sEventNameSlug = 'outdoor_raid';
  
  $oPVPRaidEventType->sEventTypeID  = $oPVPRaidEventType->guid();
  $oPVPRaidEventType->sEventName    = 'PVP Raid';
  $oPVPRaidEventType->sEventNameSlug = 'pvp_raid';
  
  foreach(array($oDungeonRaidEventType,$oOutdoorRaidEventType,$oPVPRaidEventType) as $oEventType) {
    
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
  
  // Define some scores
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
    
};

