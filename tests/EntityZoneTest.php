<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystemZone;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;



class EntityZoneTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','zone-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','zone-after.php'])
                                 ->getTable('pt_system_zone');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entityRemoveFailsWhenMissingEpisodeDataTest();
        $this->entitySaveNewEntityTest();
        $this->entitySaveFailedWhenNonCurrentParentSystemTest();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $this->assertTablesEqual($oExpectedDataset,$this->getConnection()->createDataSet()->getTable('pt_system_zone'));
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
     public function entityRemoveFailsWhenMissingEpisodeDataTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        
        $oEntity = new PointSystemZone($oGateway,$oLogger);
        
        $oEntity->sSystemID  = '583D9777-AA78-47EC-BCB6-EB60471B2C32';
        $oEntity->sZoneID    =  '68902DCF-EFBA-9C53-DD28-A26F667C5786';
        $oEntity->iEpisodeID = null;
        
        $bResult = $oEntity->remove($oProcessingDate);
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Require and Episode Id',$aResult['msg']);
        $this->assertFalse($bResult);
    }
    
     protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sZoneId   = '89BF34B3-599F-5A57-C07F-8F08CA9F4845';
        $sSystemId = '9B753E70-881B-F53E-2D46-8151BED1BBAF'; // Donataions System from example fixture
        $sZoneName = 'Mock Zone';
        $sZoneSlug = 'mock_zone';
        $sEnabledFrom = $oGateway->getNow()->format('Y-m-d');
        $sEnabledTo   = (new DateTime('3000-01-01'))->format('Y-m-d');
        
        $oEntity = new PointSystemZone($oGateway,$oLogger);
        
        $oEntity->sSystemID     = $sSystemId;
        $oEntity->sZoneID       = $sZoneId;
        $oEntity->sZoneName     = $sZoneName;
        $oEntity->sZoneNameSlug = $sZoneSlug;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new Points System Zone Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(8,$oEntity->iEpisodeID);

        
    } 
    
    protected function entitySaveFailedWhenNonCurrentParentSystemTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sZoneId   = '5644342C-B138-FD98-D1CC-DA19E73877E8';
        $sSystemId = '583D9777-AA78-47EC-BCB6-EB60471B2C32'; // Inactive System (not current)
        $sZoneName = 'Bad Parent Zone';
        $sZoneSlug = 'bad_parent_zone';
        $sEnabledFrom = $oGateway->getNow()->format('Y-m-d');
        $sEnabledTo   = (new DateTime('3000-01-01'))->format('Y-m-d');
        
        $oEntity = new PointSystemZone($oGateway,$oLogger);
        
        $oEntity->sSystemID     = $sSystemId;
        $oEntity->sZoneID       = $sZoneId;
        $oEntity->sZoneName     = $sZoneName;
        $oEntity->sZoneNameSlug = $sZoneSlug;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check PointSystem',$aResult['msg']);
        $this->assertFalse($bResult);
        
        
        
    }
    
    public function entityUpdateExistingEpisodeTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        $oEntity = new PointSystemZone($oGateway,$oLogger);
        
        $sZoneId = '663CC8C6-5E5C-D59A-3580-BA949E7ABB27';
        $sZoneName  = 'Updateable Zone Changed';
        $sZoneSlug = 'updateable_zone_changed';
        $sSystemId = '9B753E70-881B-F53E-2D46-8151BED1BBAF';
        
        $oEntity->sSystemID     = $sSystemId;
        $oEntity->sZoneID       = $sZoneId;
        $oEntity->sZoneName     = $sZoneName;
        $oEntity->sZoneNameSlug = $sZoneSlug;
        $oEntity->oEnabledFrom  = new DateTime('now');
        $oEntity->iEpisodeID    = 6;
        
        
        // save the entity
        $bResult = $oEntity->save();
        
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing Points System Zone Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(6,$oEntity->iEpisodeID); // not changed episode
    }
    
    
    public function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        $oEntity = new PointSystemZone($oGateway,$oLogger);
        
        $sZoneId = '146CD46A-A14A-AD02-9A69-FBF7AC302A81';
        $sZoneName  = 'New Version Created';
        $sZoneSlug = 'new_version_created';
        $sSystemId = '9B753E70-881B-F53E-2D46-8151BED1BBAF';
        
        $oEntity->sSystemID     = $sSystemId;
        $oEntity->sZoneID       = $sZoneId;
        $oEntity->sZoneName     = $sZoneName;
        $oEntity->sZoneNameSlug = $sZoneSlug;
        $oEntity->oEnabledFrom  = new DateTime('now - 7 day');
        $oEntity->oEnabledTo    = new DateTime('3000-01-01');
        $oEntity->iEpisodeID    = 7;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new Points System Zone Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(9,$oEntity->iEpisodeID); // new episode
    }
    
    
    public function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        $oEntity = new PointSystemZone($oGateway,$oLogger);
        
        $sZoneId = '03D119A2-1B66-423C-401F-7CE384450CE5'; //from example set has relations
        $sSystemId = '9B753E70-881B-F53E-2D46-8151BED1BBAF';
        
        $oEntity->sSystemID     = $sSystemId;
        $oEntity->sZoneID       = $sZoneId;
        $oEntity->iEpisodeID    = 1;
        
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check AdjustmentZone',$aResult['msg']);
        $this->assertFalse($bResult);
        
        
        
    }
    
     public function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        $oEntity = new PointSystemZone($oGateway,$oLogger);
        
        $sZoneId = '68902DCF-EFBA-9C53-DD28-A26F667C5786'; //current with no relations
        $sSystemId = '9B753E70-881B-F53E-2D46-8151BED1BBAF';
        
        $oEntity->sSystemID     = $sSystemId;
        $oEntity->sZoneID       = $sZoneId;
        $oEntity->iEpisodeID    = 5;
        
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals($oEntity->oEnabledTo->format('Y-m-d'),(new DateTime('now'))->format('Y-m-d'));
        
        
        
    }
    
}
/* End of File */