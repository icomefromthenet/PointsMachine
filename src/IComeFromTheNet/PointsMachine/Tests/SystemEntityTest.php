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
    
    public function getDataSet()
    {
      return new ArrayDataSet(__DIR__.'/fixture/'.'example-system.php');
    }
    
    
    public function testEntitySave()
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
        $bResult = $oEntity->save($oProcessingDate);
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Inserted new Points System Episode',$aResult['msg']);
        $this->assertTrue($bResult);

        
        $this->assertTablesEqual((new ArrayDataSet(__DIR__.'/fixture/'.'system-create.php'))->getTable('pt_system'), $this->getConnection()->createDataSet()->getTable('pt_system'));
        
    }
    
    public function testEntityUpdate()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
        
        # this is a non temporal update, this won't change the version.


        $sNewName = 'Test Donations System';
        $sNewSlug = 'test_donations_system';
        $sExistingSystemID   = '9B753E70-881B-F53E-2D46-8151BED1BBAF';
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
        
        $this->assertTablesEqual((new ArrayDataSet(__DIR__.'/fixture/'.'system-update.php'))->getTable('pt_system'), $this->getConnection()->createDataSet()->getTable('pt_system'));
        
    }
    
    public function testDeleteFailes()
    {
        
        
    }
    
    
}
/* End of File */