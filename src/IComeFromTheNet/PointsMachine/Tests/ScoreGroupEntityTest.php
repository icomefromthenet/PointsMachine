<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\ScoreGroup;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;



class ScoreGroupEntityTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','scoregroup-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','scoregroup-after.php'])
                                 ->getTable('pt_score_group');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entitySaveFailedWhenNonCurrentEpisode();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $this->assertTablesEqual($oExpectedDataset,$this->getConnection()->createDataSet()->getTable('pt_score_group'));
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreGroupId   = '7DE4013D-BD1F-1709-15ED-9A24AA4C7A98';
        $sGroupName = 'Mock Score Group';
        $sGroupSlug = 'mock_score_group';
        
        $oEntity = new ScoreGroup($oGateway,$oLogger);
        
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sGroupName     = $sGroupName;    
        $oEntity->sGroupNameSlug = $sGroupSlug;
      
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new Score Group Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(9,$oEntity->iEpisodeID);

        
    } 
    
    protected function entitySaveFailedWhenNonCurrentEpisode()
    {
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreGroupId   = '62A58FF0-97F7-1D23-A88D-C00D9542FF18';
        $iEpisodeId   = 8; 
        $sGroupName = 'Illegal op';
        $sGroupSlug = 'illegan_op';
        
        $oEntity = new ScoreGroup($oGateway,$oLogger);
        
        $oEntity->sScoreGroupID = $sScoreGroupId;
        $oEntity->sGroupName     = $sGroupName;    
        $oEntity->sGroupNameSlug = $sGroupSlug;
        $oEntity->iEpisodeID    = $iEpisodeId;
        $oEntity->oEnabledFrom   = (new DateTime('now - 8 day'));
        $oEntity->oEnabledTo     = (new DateTime('now -1 day'));
      
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Unable to decide which operation to use',$aResult['msg']);
        $this->assertFalse($bResult);
    
    
        
    }
    
    protected function entityUpdateExistingEpisodeTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreGroupId   = 'CD48671F-DE97-6C41-70B9-1060FDC4433D';
        $iEpisodeId   = 6; 
        $sGroupName = 'Can be Updated Again';
        $sGroupSlug = 'can_be_updated_again';
        
        
        $oEntity = new ScoreGroup($oGateway,$oLogger);
        
        $oEntity->sScoreGroupID = $sScoreGroupId;
        $oEntity->sGroupName     = $sGroupName;    
        $oEntity->sGroupNameSlug = $sGroupSlug;
        $oEntity->iEpisodeID    = $iEpisodeId;
        $oEntity->oEnabledFrom   = (new DateTime('now'));
        $oEntity->oEnabledTo     = (new DateTime('3000-01-01'));
      
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing Score Group Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        
        
    }
    
    protected function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreGroupId   = '30FAB3CD-B30A-C750-DF96-41A38A0998BC';
        $iEpisodeId   = 7; 
        $sGroupName = 'Created New Version';
        $sGroupSlug = 'created_new_version';
        
        
        $oEntity = new ScoreGroup($oGateway,$oLogger);
        
        $oEntity->sScoreGroupID = $sScoreGroupId;
        $oEntity->sGroupName     = $sGroupName;    
        $oEntity->sGroupNameSlug = $sGroupSlug;
        $oEntity->iEpisodeID    = $iEpisodeId;
        $oEntity->oEnabledFrom   = (new DateTime('now - 7 day'));
        $oEntity->oEnabledTo     = (new DateTime('3000-01-01'));
      
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new Score Group Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        
    }
    
    protected function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreGroupId  = 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED';
        $iEpisodeId     = 1; 
         $sGroupName    = 'Enchanting Supplies';
        $sGroupSlug     = 'enchanting_supplies';
       
        
        $oEntity = new ScoreGroup($oGateway,$oLogger);
        
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sGroupName     = $sGroupName;    
        $oEntity->sGroupNameSlug = $sGroupSlug;
        $oEntity->iEpisodeID     = $iEpisodeId;
      
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check Score',$aResult['msg']);
        $this->assertFalse($bResult);
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreGroupId  = '08AA3D4D-2166-2F9D-3C2F-393AFFC59125';
        $iEpisodeId     = 5; 
        $sGroupName    = 'No Relations';
        $sGroupSlug     = 'no_relations';
       
        
        $oEntity = new ScoreGroup($oGateway,$oLogger);
        
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sGroupName     = $sGroupName;    
        $oEntity->sGroupNameSlug = $sGroupSlug;
        $oEntity->iEpisodeID     = $iEpisodeId;
      
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */