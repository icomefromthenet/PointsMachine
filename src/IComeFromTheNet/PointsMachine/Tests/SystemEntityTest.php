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
    
    
    /*
    public function testEntitySave()
    {
        
        $oExpectedDataset = $this->getDataSet(array_merge($this->aFixtures
                                                            ,['system-create-after.php'])
                                                            )
                                ->getTable('pt_system');
        
        
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
        $bResult = $oEntity->save($oProcessingDate);
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Inserted new Points System Episode',$aResult['msg']);
        $this->assertTrue($bResult);

        
        $this->assertTablesEqual($oExpectedDataset, $this->getConnection()->createDataSet()->getTable('pt_system'));
        
    } */
    
    public function testEntityUpdate()
    {
        
       $oExpectedDataset = $this->getDataSet(array_merge($this->aFixtures
                                                            ,['system-update-after.php'])
                                                            )
                                ->getTable('pt_system');
        
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        # this is a non temporal update, this won't change the version.


        $sNewName = 'Test Donations System';
        $sNewSlug = 'test_donations_system';
        $sExistingSystemID   = '5CC68937-12BF-C9B9-97E0-3745649101F4';
        $iExistingEpisode = 1;
        
        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $oEntity->sSystemID = $sExistingSystemID;
        $oEntity->sSystemName =$sNewName;
        $oEntity->sSystemNameSlug = $sNewSlug;
        $oEntity->iEpisodeID = $iExistingEpisode;
        
        $bResult = $oEntity->save($oProcessingDate);
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertTrue($bResult);
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated All the Points System Episodes',$aResult['msg']);
        
        $this->assertTablesEqual($oExpectedDataset,$this->getConnection()->createDataSet()->getTable('pt_system'));
        
    }
    
    /**
     *
     * @expectedException IComeFromTheNet\PointsMachine\PointsMachineException
     * @expectedExceptionMessage Require and Episode Id and Entity Id to delete and episode
     * 
     */ 
    public function testRemoveFailsWhenMissingEpisodeData()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        # this is a non temporal update, this won't change the version.

        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $sExistingSystemID   =
        $iExistingEpisode = 1;
        
        $oEntity->sSystemID =  '9B753E70-881B-F53E-2D46-8151BED1BBAF';
        $oEntity->iEpisodeID = null;
        
        $oEntity->remove($oProcessingDate);
    }
    
    /*
    public function testRemoveFailsOnRelationsKeyCheck()
    {
        $oExpectedDataset = $this->getDataSet(array_merge($this->aFixtures
                                                            ,['system-remove-after.php'])
                                                            )
                                ->getTable('pt_system');
        
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        $oRuleChainGateway     = $oGateway->getGatewayCollection()->getGateway('pt_rule_chain');
        $oSystemZoneGateway    = $oGateway->getGatewayCollection()->getGateway('pt_system_zone');
        $oAdjGroupLimitGateway = $oGateway->getGatewayCollection()->getGateway('pt_rule_group_limits');
        
         
                
        $aTablesFailed[] = $oSystemZoneGateway->getMetaData()->getName();   
        $aTablesFailed[] = $oAdjGroupLimitGateway->getMetaData()->getName();   
        $aTablesFailed[] = $oRuleChainGateway->getMetaData()->getName();   
    
        
        
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
    
    public function testRemoveSucessful()
    {
       # add another record for us to remove 
       $this->loadDataSet(array('example-system.php','system-remove-before.php')) ;
       
        
      $this->assertTablesEqual((new ArrayDataSet(__DIR__.'/fixture/'.'system-remove-after.php'))->getTable('pt_system'), $this->getConnection()->createDataSet()->getTable('pt_system'));
    } */
}
/* End of File */