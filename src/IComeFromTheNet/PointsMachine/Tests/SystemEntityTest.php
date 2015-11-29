<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\Tests\Base\SimpleArrayDataSet;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystem;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use PHPUnit_Extensions_Database_DataSet_CompositeDataSet;
use PHPUnit_Extensions_Database_DataSet_DataSetFilter;
use PHPUnit_Extensions_Database_DataSet_QueryDataSet;


class SystemEntityTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','system-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','system-after.php'])
                                 ->getTable('pt_system');
        
        $this->entityRemoveFailsWhenMissingEpisodeDataTest();
        $this->entitySaveNewEntityTest();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $this->assertTablesEqual($oExpectedDataset,$this->getConnection()->createDataSet()->getTable('pt_system'));
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
     public function entityRemoveFailsWhenMissingEpisodeDataTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        # this is a non temporal update, this won't change the version.

        $oEntity = new PointSystem($oGateway,$oLogger);
        
        
        $oEntity->sSystemID =  '9B753E70-881B-F53E-2D46-8151BED1BBAF';
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
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sSystemId = '1E8659DA-127C-BE67-6DF5-EB6554AD4B0';
        $sSystemName = 'Mock System';
        $sSystemSlug = 'mock_system';
        $sEnabledFrom = $oGateway->getNow()->format('Y-m-d');
        $sEnabledTo   = (new DateTime('3000-01-01'))->format('Y-m-d');
        
        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $oEntity->sSystemID = $sSystemId;
        $oEntity->sSystemName = $sSystemName;
        $oEntity->sSystemNameSlug = $sSystemSlug;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new Points System Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(5,$oEntity->iEpisodeID);

        
    } 
    
    public function entityUpdateExistingEpisodeTest()
    {
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        # this is a non temporal update, this won't change the version.

        $sNewName = 'Existing Episode Updated';
        $sNewSlug = 'existing_episode_updated';
        $sExistingSystemID   = '5CC68937-12BF-C9B9-97E0-3745649101F4';
        $iExistingEpisode = 3;
        
        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $oEntity->sSystemID = $sExistingSystemID;
        $oEntity->sSystemName =$sNewName;
        $oEntity->sSystemNameSlug = $sNewSlug;
        $oEntity->iEpisodeID = $iExistingEpisode;
        
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($bResult);
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing Points System Episode',$aResult['msg']);
       
        
    }
    
    public function entityUpdateCauseNewVersionTest()
    {
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        # this is a non temporal update, this won't change the version.

        $sNewName = 'New Episode Created';
        $sNewSlug = 'new_episode_created';
        $sExistingSystemID   = '6663DE9B-9076-3670-C50A-94EE64016AB6';
        $iExistingEpisode = 4;
        
        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $oEntity->sSystemID = $sExistingSystemID;
        $oEntity->sSystemName =$sNewName;
        $oEntity->sSystemNameSlug = $sNewSlug;
        $oEntity->iEpisodeID = $iExistingEpisode;
        $oEntity->oEnabledFrom = new DateTime('now - 10 day');
        
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($bResult);
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new Points System Episode',$aResult['msg']);
        $this->assertEquals(6,$oEntity->iEpisodeID);
        
    }
  
    
    public function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        $oRuleChainGateway     = $oGateway->getGatewayCollection()->getGateway('pt_rule_chain');
        $oSystemZoneGateway    = $oGateway->getGatewayCollection()->getGateway('pt_system_zone');
        $oAdjGroupLimitGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_group_limits');
        
         
                
        $aTablesFailed[] = 'SystemZone';
        $aTablesFailed[] = 'AdjustmentGroup';
        $aTablesFailed[] = 'RuleChain';
    
        
        # this is a non temporal update, this won't change the version.

        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $sExistingSystemID   =
        $iExistingEpisode = 1;
        
        $oEntity->sSystemID =  '9B753E70-881B-F53E-2D46-8151BED1BBAF';
        $oEntity->iEpisodeID = 1;
        
        $bResult = $oEntity->remove($oProcessingDate);
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($bResult);
        $this->assertFalse($aResult['result']);
        
        $this->assertRegExp('/'.$aTablesFailed[0].'/', $aResult['msg']);
        $this->assertRegExp('/'.$aTablesFailed[1].'/', $aResult['msg']);
        $this->assertRegExp('/'.$aTablesFailed[2].'/', $aResult['msg']);
        
    }
    
    public function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        $oNow = $oGateway->getNow();
        
        # this is a non temporal update, this won't change the version.

        $sExistingSystemID   = '583D9777-AA78-47EC-BCB6-EB60471B2C32';
        $iExistingEpisode = 2;
        
        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $oEntity->sSystemID = $sExistingSystemID;
        $oEntity->iEpisodeID = $iExistingEpisode;
        
        
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($bResult);
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this episode',$aResult['msg']);
        $this->assertEquals($oNow,$oEntity->oEnabledTo);
      
      
    } 
}
/* End of File */