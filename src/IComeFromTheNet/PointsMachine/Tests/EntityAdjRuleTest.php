<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentRule;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;


class EntityAdjRuleTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','adj-rule-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','adj-rule-after.php'])
                                 ->getTable('pt_rule');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        $this->entityCreateFailsOnFKTest();
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $sSql  = ' SELECT episode_id, rule_id, rule_group_id ,rule_name, rule_name_slug, ';
        $sSql .= '       multiplier, modifier, modifier, invert_flag,' ;
        $sSql .= '       enabled_from, enabled_to  ' ;
        $sSql .= ' FROM pt_rule';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_rule',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $iEpisodeId      = null;   
        $sAdjRuleId      = 'AA9C989D-3823-44CF-B74A-E6E3784D2335';
        $sAdjRuleGroupId = '644ACED6-94F8-FF4B-B66E-BB572338AC4B';
        $sRuleName       = 'A New Rule';
        $sRuleNameSlug   = 'a_new_rule';
        $fMultiplier     = null;
        $fModifier       = 67;
        $bInvertFlag     = true;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentRule($oGateway,$oLogger);
    
  
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sRuleName          = $sRuleName;
        $oEntity->sRuleNameSlug      = $sRuleNameSlug;  
        $oEntity->fMultiplier        = $fMultiplier;
        $oEntity->fModifier          = $fModifier;
        $oEntity->bInvertFlag        = $bInvertFlag;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new AdjustmentRule Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(11,$oEntity->iEpisodeID);

        
    } 
    
  
    protected function entityUpdateExistingEpisodeTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 9;   
        $sAdjRuleId      = '2B84454D-69CC-E95D-4A71-61594FC23B8C';
        $sAdjRuleGroupId = '644ACED6-94F8-FF4B-B66E-BB572338AC4B';
        $sRuleName       = 'Rule That can be Updated';
        $sRuleNameSlug   = 'rule_that_can_be_updated';
        $fMultiplier     = null;
        $fModifier       = 67;
        $bInvertFlag     = false;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentRule($oGateway,$oLogger);
    
  
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sRuleName          = $sRuleName;
        $oEntity->sRuleNameSlug      = $sRuleNameSlug;  
        $oEntity->fMultiplier        = $fMultiplier;
        $oEntity->fModifier          = $fModifier;
        $oEntity->bInvertFlag        = $bInvertFlag;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing AdjustmentRule Episode',$aResult['msg']);
        $this->assertTrue($bResult);
       
        
        
    }
    
    protected function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 8;   
        $sAdjRuleId      = 'FAF37D16-4BC4-C778-09A5-8C59A622A22D';
        $sAdjRuleGroupId = '644ACED6-94F8-FF4B-B66E-BB572338AC4B';
        $sRuleName       = 'A new version';
        $sRuleNameSlug   = 'a_new_version';
        $fMultiplier     = null;
        $fModifier       = 5;
        $bInvertFlag     = false;
        $oEnabledFrom    = (new DateTime('now - 1 day'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentRule($oGateway,$oLogger);
    
  
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sRuleName          = $sRuleName;
        $oEntity->sRuleNameSlug      = $sRuleNameSlug;  
        $oEntity->fMultiplier        = $fMultiplier;
        $oEntity->fModifier          = $fModifier;
        $oEntity->bInvertFlag        = $bInvertFlag;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new AdjustmentRule Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(12,$oEntity->iEpisodeID);
        
    }
    
     protected function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
      
        $iEpisodeId      = 10;   
        $sAdjRuleId      = 'E6731CF5-FC30-9386-AC6C-D3FC1A62A059';
        $sAdjRuleGroupId = '644ACED6-94F8-FF4B-B66E-BB572338AC4B';
        $sRuleName       = 'Not Be Closed';
        $sRuleNameSlug   = 'not_be_closed';
        $fMultiplier     = 1;
        $fModifier       = null;
        $bInvertFlag     = true;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentRule($oGateway,$oLogger);
    
  
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sRuleName          = $sRuleName;
        $oEntity->sRuleNameSlug      = $sRuleNameSlug;  
        $oEntity->fMultiplier        = $fMultiplier;
        $oEntity->fModifier          = $fModifier;
        $oEntity->bInvertFlag        = $bInvertFlag;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check AdjustmentZone',$aResult['msg']);
        $this->assertFalse($bResult);
        
    }
    
    
    protected function entityCreateFailsOnFKTest()
    {
       $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $iEpisodeId      = null;   
        $sAdjRuleId      = 'AA9C989D-3823-44CF-B74A-E6E3784D2335';
        $sAdjRuleGroupId = '7991CD0B-7061-C5CE-C360-67A3E19D7ED2'; //expired group;
        $sRuleName       = 'A New Rule';
        $sRuleNameSlug   = 'a_new_rule';
        $fMultiplier     = null;
        $fModifier       = 67;
        $bInvertFlag     = true;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentRule($oGateway,$oLogger);
    
  
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sRuleName          = $sRuleName;
        $oEntity->sRuleNameSlug      = $sRuleNameSlug;  
        $oEntity->fMultiplier        = $fMultiplier;
        $oEntity->fModifier          = $fModifier;
        $oEntity->bInvertFlag        = $bInvertFlag;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check AdjustmentRuleGroup',$aResult['msg']);
        $this->assertFalse($bResult);
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 7;   
        $sAdjRuleId      = 'AFF9593-589D-4C7D-6924-82B5EBD4F253';
        $sAdjRuleGroupId = '644ACED6-94F8-FF4B-B66E-BB572338AC4B';
        $sRuleName       = 'Rule That can be Closed';
        $sRuleNameSlug   = 'rule_can_be_closed';
        $fMultiplier     = 1;
        $fModifier       = null;
        $bInvertFlag     = true;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentRule($oGateway,$oLogger);
    
  
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentRuleID  = $sAdjRuleId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sRuleName          = $sRuleName;
        $oEntity->sRuleNameSlug      = $sRuleNameSlug;  
        $oEntity->fMultiplier        = $fMultiplier;
        $oEntity->fModifier          = $fModifier;
        $oEntity->bInvertFlag        = $bInvertFlag;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this AdjustmentRule episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */