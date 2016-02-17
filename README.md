# PointsMachine
Library to build Points Systems for MySql.

#Overview
PointsMachine allows user defined rule systems that can be configured though values stored in database. 

PointsMachine does not provide the GUI but is a set of classes that will manage the processing and storage of rules and scores.

A points run starts with a selection of scores that are then applied to a formula defined as a series of rule groups chain together with each group containg one to many adjustment rules that either modify or multiply the base score. These scorce can then be rounded and capped.  


# Getting Started.
To show you how this library is to be used I will implement a DKP or (Dragon Kill Points) system that are used in Gaming Guids. (I used to play alot of World of Warcraft).

## Boostrap the Library

First step is to create the system but before we can do that we need to bootstrap the Library Service Container.

```php

// Start the Database

$connectionParams = array(
    'dbname' => $DEMO_DATABASE_SCHEMA,
    'user' => $DEMO_DATABASE_USER,
    'password' => $DEMO_DATABASE_PASSWORD,
    'host' => $DEMO_DATABASE_HOST,
    'driver' => $DEMO_DATABASE_TYPE,
);

$oConn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);


// Start the Logger

$oLog = new BufferedQueryLogger();
$oLog->setMaxBuffer(100);
$oConn->getConfiguration()->setSQLLogger($oLog);

// create a log channel
$ologger = new Logger('runner');
$ologger->pushHandler(new StreamHandler(__DIR__.'/out.log', Logger::DEBUG));


// Start Event Dispatcher

$oEvent = new EventDispatcher();

// Create the Container

$oPointsContainer = new PointsMachineContainer($oEvent,$oConn,$ologger);
 
// Bootstrap the container

$oPointsContainer->boot(new \DateTime('now'));


```

## System and SystemZones

After the container is started we will be able to start configuring this system.

I use an Active Record pattern to build this libraries data model each entity has both
a entity::save() and entity::remove() with each entity having 2 constructor arguments.

1. Table Gateway for the database table this entity represents,
2. The Application Logger,


```php

   
  $oSystemGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_system');
  $oLogger        = $oPointsContainer->getAppLogger();
 
  
  $oPointSystem = new PointSystem($oSystemGateway,$oLogger);
    
  $oPointSystem->sSystemID       = $oPointSystem->guid();
  $oPointSystem->sSystemName     = 'Raid Calculator';
  $oPointSystem->sSystemNameSlug = 'raid_calculator';
  
  $bResult = $oPointSystem->save();
  $aLastResult = $oPointSystem->getLastQueryResult();
  
  if(false === $bResult) {
    throw new \RuntimeException($aLastResult['msg']);
  }  

```

After we have defind a name for our points system we should consider if we need any SystemZones.  

A System has Zones these zones should be mutually exclusive to each other for example sales territories. These zones are used to further filter which rules should apply to a score. 

For our Raid Calcualtor I'm going to use character classes.


```php

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


```

## Events Types

This abstraction is used to group occurances that would cause a calcualtion run in this raid calcualtor an event could a dungeon raid, an outdoor raid, ro a PVP raid.


```php

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
      throw new \RuntimeException($oZone->sEventName .' '.$aLastResult['msg']);
    }
    
  }



```

## Score and Score Groups

Scores are the starting values. If this library was used as a discount calculator you could have one score per product but with dungeon raid each score will instead represent
a minium allowance for attendence. 

Score Groups are used to categories multiple score values together with the groups used as filters during a caluclation run.

We start of with 3 Score Groups.

1. PVP Scores
2. PVP Scores
3. Donations.


```php




```

#Concepts Overview:

##Period of Validity.
Many of the entities (Rules,Scores,Chains) all have a period of applicability. This library does not allow for future data only current. For example a delete operation will cause an existing entity to be closed meaning the databse record is not removed only its valid date range changed. If new entity is added it is active from that date. 

##Systems and Zones
All Formulas and Rules are linked to a System if you are running multiple reward schemes they would each belong to a different system. 




## Score and Score Groups
A Score is a starting point each score has a value. This value will be modified by the processor.

You may have many scores in calculation run each score is modified independently. 

Each Score may belong to a single Score Group. 

Each product in your catelog could be assigned its own score with product categories making up the score groups.

## Adjustment Rules and Adjustment Groups
An adjustment rule contains a modifier and a multipler they can be:
1. Linked to specific system zones.
2. Linked to only a single Adjustment Group.

A rule multipler is a multiplication operation.
A rule modifier is a addition operation.


An Adjustment Group is a container for one or more Adjustment Rules.

A group has the following functions.
1. Be linked to only apply on specific Score Groups (different groups for each product category)
2. Be linked to one more Points Systems. (reuse one group across multiple point systems)
3. Have a maximum and minimum multipler and modifier (based on combined value of adjustment rules applied in the run)
4. Group can me made to be mandatory (always apply its rules)
5. Limit on number of adjustment rules that are applied to score (limit to a single rule).
6. Change how the linked rules are ordered (max or min).

For example you can have an adjustment group apply only a single largest rule from those included in a calculation run.



> If you developing a system and do not need the end user to configure the values through a GUI I would recommend that avoid using a library like mine.



