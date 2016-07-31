<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\EventType;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;


class EntityEventTypeTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','event-type-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event_type');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','event-type-after.php'])
                                 ->getTable('pt_event_type');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $sSql  = ' SELECT episode_id, event_type_id, event_name, event_name_slug, enabled_from, enabled_to  ' ;
        $sSql .= ' FROM pt_event_type';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_event_type',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event_type');
        $oLogger    = $oContainer->getAppLogger();
     
       
        // Build the entity to save
        $sEventTypeId = 'B1A77C7D-F0A6-E2F5-5297-30E3CFC758D1';
        $sEventName     ='New Type';
        $sEventNameSlug ='new_type';
        $oEnabledFrom = (new DateTime('now'));
        $oEnabledTo = (new DateTime('3000-01-01'));
      
        
        $oEntity = new EventType($oGateway,$oLogger);
      
        $oEntity->sEventTypeID   = $sEventTypeId;
        $oEntity->sEventName     = $sEventName;
        $oEntity->sEventNameSlug = $sEventNameSlug;
        $oEntity->oEnabledFrom   = $oEnabledFrom;
        $oEntity->oEnabledTo     = $oEnabledTo ;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new EventType Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(7,$oEntity->iEpisodeID);

        
    } 
    
   
    
    protected function entityUpdateExistingEpisodeTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event_type');
        $oLogger    = $oContainer->getAppLogger();
  
       
        // Build the entity to save
        
        $oEntity = new EventType($oGateway,$oLogger);
      
        $iEpisodeId    = 4;
        $sEventTypeId  = '4C7DD3D9-420B-CDD4-5D47-D99A325BDBF6';
        $sEventName     ='Updated Type';
        $sEventNameSlug ='updated_type';
        $oEnabledFrom = new DateTime('now');
        $oEnabledTo   = new DateTime('3000-01-01');
        
        
        $oEntity = new EventType($oGateway,$oLogger);
      
        $oEntity->iEpisodeID     = $iEpisodeId; 
        $oEntity->sEventTypeID   = $sEventTypeId;
        $oEntity->sEventName     = $sEventName;
        $oEntity->sEventNameSlug = $sEventNameSlug;
        $oEntity->oEnabledFrom   = $oEnabledFrom;
        $oEntity->oEnabledTo     = $oEnabledTo ;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing EventType Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        
        
    }
    
    protected function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event_type');
        $oLogger    = $oContainer->getAppLogger();
 
       
        // Build the entity to save
        
        $oEntity = new EventType($oGateway,$oLogger);
      
        $iEpisodeId    = 5;
        $sEventTypeId = '83348551-9A81-C9B8-61B8-654DD25D5907';
        $sEventName     ='New Version';
        $sEventNameSlug ='new_version';
        $oEnabledFrom = new DateTime('now - 1 day');
        $oEnabledTo   = new DateTime('3000-01-01');
        
        
        $oEntity = new EventType($oGateway,$oLogger);
      
        $oEntity->iEpisodeID     = $iEpisodeId; 
        $oEntity->sEventTypeID   = $sEventTypeId;
        $oEntity->sEventName     = $sEventName;
        $oEntity->sEventNameSlug = $sEventNameSlug;
        $oEntity->oEnabledFrom   = $oEnabledFrom;
        $oEntity->oEnabledTo     = $oEnabledTo ;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new EventType Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        
    }
    
    
    
    
    protected function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event_type');
        $oLogger    = $oContainer->getAppLogger();
      
       
        // Build the entity to save
        
        $oEntity = new EventType($oGateway,$oLogger);
        
        $iEpisodeId    = 3;
        $sEventTypeId = '55A33394-E759-611A-3015-A17B86469B5D'; 
        $sEventName     ='Current Type';
        $sEventNameSlug ='current_type';
        $oEnabledFrom = new DateTime('now');
        $oEnabledTo   = new DateTime('3000-01-01');
        
        
        $oEntity = new EventType($oGateway,$oLogger);
      
        $oEntity->iEpisodeID     = $iEpisodeId; 
        $oEntity->sEventTypeID   = $sEventTypeId;
        $oEntity->sEventName     = $sEventName;
        $oEntity->sEventNameSlug = $sEventNameSlug;
        $oEntity->oEnabledFrom   = $oEnabledFrom;
        $oEntity->oEnabledTo     = $oEnabledTo ;
        
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check RuleChain',$aResult['msg']);
        $this->assertFalse($bResult);
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_event_type');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $oEntity = new EventType($oGateway,$oLogger);
        
        $iEpisodeId    = 6;
        $sEventTypeId = '1210A00C-4EB7-9042-F19E-38E865B4E01'; 
        $sEventName     ='Can be closed';
        $sEventNameSlug ='can_be_closed';
        $oEnabledFrom = new DateTime('now - 1 day');
        $oEnabledTo   = new DateTime('3000-01-01');
        
        
        $oEntity = new EventType($oGateway,$oLogger);
      
        $oEntity->iEpisodeID     = $iEpisodeId; 
        $oEntity->sEventTypeID   = $sEventTypeId;
        $oEntity->sEventName     = $sEventName;
        $oEntity->sEventNameSlug = $sEventNameSlug;
        $oEntity->oEnabledFrom   = $oEnabledFrom;
        $oEntity->oEnabledTo     = $oEnabledTo ;
        
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this EventType episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */