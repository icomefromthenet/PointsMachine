<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentZone;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;


class EntityAdjZoneTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','adj-zone-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','adj-zone-after.php'])
                                 ->getTable('pt_rule_sys_zone');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityCreateFailsOnFKTest();
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $sSql  = ' SELECT episode_id,rule_id, zone_id, enabled_from, enabled_to ' ;
        $sSql .= ' FROM pt_rule_sys_zone';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_rule_sys_zone',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_sys_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $iEpisodeId      = null;   
        $sAdjRuleId      = 'CBEB772F-6E96-5A83-0F24-9F9B363ED240';  
        $sZoneId         = '65E04897-6F62-3A89-A2F6-675C7105549A';
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentZone($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sSystemZoneID      = $sZoneId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new AdjustmentZone Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(5,$oEntity->iEpisodeID);

        
    } 
    
  
    protected function entityUpdateExistingEpisodeTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_sys_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 4;   
        $sAdjRuleId      = 'AD5B6D76-A0F5-4688-CE81-835F901CB725'; // updated field 
        $sZoneId         = '532CE54F-13F4-3E88-3F31-8F41EE3E6E3A'; // updated field
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentZone($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sSystemZoneID      = $sZoneId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing AdjustmentZone Episode',$aResult['msg']);
        $this->assertTrue($bResult);
       
        
        
    }
    
    
    
     protected function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        // no keys to check
        
    }
    
    
    protected function entityCreateFailsOnFKTest()
    {
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_sys_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $iEpisodeId      = null;   
        $sAdjRuleId      = '02B7B97C-22B8-E2D1-AE53-9D72F7E9473D';  //expired rule 
        $sZoneId         = '2ECC840F-806A-C0F0-552D-E450F582A5D1';  //expired zone
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentZone($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sSystemZoneID      = $sZoneId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check AdjustmentRule,SystemZone',$aResult['msg']);
        
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_sys_zone');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 3;   
        $sAdjRuleId      = 'CBEB772F-6E96-5A83-0F24-9F9B363ED240'; // updated field 
        $sZoneId         = '5E02B643-1352-C3D9-FB16-C9B9BB0C88C0'; // updated field
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentZone($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sSystemZoneID      = $sZoneId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this AdjustmentZone episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */