<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\Score;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;



class EntityScoreTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','score-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','score-after.php'])
                                 ->getTable('pt_score');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entitySaveFailedWhenNonCurrentEpisode();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        $this->entityUpdateFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $sSql  = ' SELECT episode_id, score_id, score_name, score_name_slug, ';
        $sSql .= '       score_value, score_group_id, enabled_from, enabled_to  ' ;
        $sSql .= ' FROM pt_score';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_score',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreId   = '8333E339-33C9-A58F-88F8-8FF5D3F837F2';
        $sScoreGroupId = 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'; // Echanting Supplies Score Group
        $sScoreName = 'Mock Score';
        $sScoreNameSlug = 'mock_score';
        $sScoreValue  = 0.2;
        
        $oEntity = new Score($oGateway,$oLogger);
        
        $oEntity->sScoreID       = $sScoreId;
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sScoreName     = $sScoreName;    
        $oEntity->sScoreNameSlug = $sScoreNameSlug;
        $oEntity->fScoreValue    = $sScoreValue;
      
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertEquals('Created new Score Episode',$aResult['msg']);
        $this->assertTrue($aResult['result']);
        $this->assertTrue($bResult);
        $this->assertEquals(16,$oEntity->iEpisodeID);

        
    } 
    
    protected function entitySaveFailedWhenNonCurrentEpisode()
    {
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreId       = '6E34457C-BF12-20A0-AEC8-B8FE436CE304';
        $sScoreGroupId  = '62A58FF0-97F7-1D23-A88D-C00D9542FF18';
        $sScoreName     = 'Non Current Score';
        $sScoreNameSlug = 'non_current_score';
        $sScoreValue    = 0.7;
        
        $oEntity = new Score($oGateway,$oLogger);
        
        $oEntity->sScoreID       = $sScoreId;
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sScoreName     = $sScoreName;    
        $oEntity->sScoreNameSlug = $sScoreNameSlug;
        $oEntity->fScoreValue    = $sScoreValue;
        $oEntity->iEpisodeID     = 12;
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
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreId       = 'BEA50E4D-0FCF-D858-62C0-2BCBB32FB746';
        $sScoreGroupId  = 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED';
        $sScoreName     = 'Score Updated';
        $sScoreNameSlug = 'score_updated';
        $sScoreValue    = 0.9;
        
        $oEntity = new Score($oGateway,$oLogger);
        
        $oEntity->sScoreID       = $sScoreId;
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sScoreName     = $sScoreName;    
        $oEntity->sScoreNameSlug = $sScoreNameSlug;
        $oEntity->fScoreValue    = $sScoreValue;
        $oEntity->iEpisodeID     = 13;
        $oEntity->oEnabledFrom   = (new DateTime('now'));
        $oEntity->oEnabledTo     = (new DateTime('3000-01-01'));
      
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing Score Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        
        
    }
    
    protected function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreId       = '000439C2-3A34-DAB8-C7AB-852CA6EC98D8';
        $sScoreGroupId  = 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED';
        $sScoreName     = 'New Episode';
        $sScoreNameSlug = 'new_episode';
        $sScoreValue    = 0.7;
        
        $oEntity = new Score($oGateway,$oLogger);
        
        $oEntity->sScoreID       = $sScoreId;
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sScoreName     = $sScoreName;    
        $oEntity->sScoreNameSlug = $sScoreNameSlug;
        $oEntity->fScoreValue    = $sScoreValue;
        $oEntity->iEpisodeID     = 14;
        $oEntity->oEnabledFrom   = (new DateTime('now - 1 day'));
        $oEntity->oEnabledTo     = (new DateTime('3000-01-01'));
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        //var_dump($this->oLog);
      
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new Score Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        
    }
    
    protected function entityUpdateFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreId       = 'BEA50E4D-0FCF-D858-62C0-2BCBB32FB746';
        $sScoreGroupId  = '62A58FF0-97F7-1D23-A88D-C00D9542FF18'; // non current score group
        $sScoreName     = 'Score Updated';
        $sScoreNameSlug = 'score_updated';
        $sScoreValue    = 0.9;
        
        $oEntity = new Score($oGateway,$oLogger);
        
        $oEntity->sScoreID       = $sScoreId;
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sScoreName     = $sScoreName;    
        $oEntity->sScoreNameSlug = $sScoreNameSlug;
        $oEntity->fScoreValue    = $sScoreValue;
        $oEntity->iEpisodeID     = 13;
        $oEntity->oEnabledFrom   = (new DateTime('now'));
        $oEntity->oEnabledTo     = (new DateTime('3000-01-01'));
        
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check ScoreGroup',$aResult['msg']);
        $this->assertFalse($bResult);
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_score');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sScoreId       = '58AEFC40-C976-70E4-9F92-134DAFDB86E9';
        $sScoreGroupId  = 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED';
        $sScoreName     = 'Closed Score';
        $sScoreNameSlug = 'closed_score';
        $sScoreValue    = 0.7;
        
        $oEntity = new Score($oGateway,$oLogger);
        
        $oEntity->sScoreID       = $sScoreId;
        $oEntity->sScoreGroupID  = $sScoreGroupId;
        $oEntity->sScoreName     = $sScoreName;    
        $oEntity->sScoreNameSlug = $sScoreNameSlug;
        $oEntity->fScoreValue    = $sScoreValue;
        $oEntity->iEpisodeID     = 15;
        $oEntity->oEnabledFrom   = (new DateTime('now - 1 day'));
        $oEntity->oEnabledTo     = (new DateTime('3000-01-01'));
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        $this->assertEquals((new DateTime('now'))->format('Y-m-d'),$oEntity->oEnabledTo->format('Y-m-d'));
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */