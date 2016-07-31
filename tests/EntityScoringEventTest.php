<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\ScoringEvent;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;



class EntityScoringEventTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','score-event-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','score-event-after.php'])
                                 ->getTable('pt_event');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
      
        $sSql  = ' SELECT event_id, event_type_id, process_date, occured_date ';
        $sSql .= ' FROM pt_event';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_event',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event');
        $oLogger    = $oContainer->getAppLogger();
       
       
        // Build the entity to save
        
        $iScoreEventId = null;
        $sEventTypeID  = '93B19460-04F4-85CD-6553-00D7125CFDAE';
        $oProcessDate  = new DateTime('now');
        $oOccuredDate  = new DateTime('now - 1 day');
       
        
        $oEntity = new ScoringEvent($oGateway,$oLogger);
        
        $oEntity->iScoringEventID = $iScoreEventId;
        $oEntity->sEventTypeID  = $sEventTypeID;
        $oEntity->oProcessDate  = $oProcessDate;
        $oEntity->oOccuredDate  = $oOccuredDate;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertEquals('Created new ScoringEvent',$aResult['msg']);
        $this->assertTrue($aResult['result']);
        $this->assertTrue($bResult);
        $this->assertEquals(3,$oEntity->iScoringEventID);

        
    } 
    
    /**
     * @expectedException IComeFromTheNet\PointsMachine\PointsMachineException
     * @expectedExceptionMessage remove operation not supported
     * 
     */ 
    public function testRemoveFails()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event');
        $oLogger    = $oContainer->getAppLogger();
       
       
        // Build the entity to save
        
        
        
        $oEntity = new ScoringEvent($oGateway,$oLogger);
        
        $oEntity->remove();
    }
    
    /**
     * @expectedException IComeFromTheNet\PointsMachine\PointsMachineException
     * @expectedExceptionMessage update operation not supported
     * 
     */ 
    public function testUpdateFails()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event');
        $oLogger    = $oContainer->getAppLogger();
       
       
        // Build the entity to save
        
        $iScoreEventId = 1;
        $sEventTypeID  = '93B19460-04F4-85CD-6553-00D7125CFDAE';
        $oProcessDate  = new DateTime('now');
        $oOccuredDate  = new DateTime('now - 1 day');
       
        
        $oEntity = new ScoringEvent($oGateway,$oLogger);
        
        $oEntity->iScoringEventID = $iScoreEventId;
        $oEntity->sEventTypeID  = $sEventTypeID;
        $oEntity->oProcessDate  = $oProcessDate;
        $oEntity->oOccuredDate  = $oOccuredDate;
        
        // save the entity
        $bResult = $oEntity->save();
      

        
    } 
}
/* End of File */