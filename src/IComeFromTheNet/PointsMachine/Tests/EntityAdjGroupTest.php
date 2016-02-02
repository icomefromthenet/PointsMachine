<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroup;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;


class EntityAdjGroupTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','adj-group-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','adj-group-after.php'])
                                 ->getTable('pt_rule_group');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        //$this->entityCreateFailsOnFKTest();
        //$this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $sSql  = ' SELECT episode_id, rule_group_id, rule_group_name, rule_group_name_slug, ';
        $sSql .= '       max_multiplier, min_multiplier, max_modifier, min_modifier, max_count,  ' ;
        $sSql .= '       order_method, is_mandatory, enabled_from, enabled_to  ' ;
        $sSql .= ' FROM pt_rule_group';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_rule_group',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $iEpisodeId      = null;   
        $sAdjRuleGroupId = 'BFB63A44-5FB4-BA2F-EF52-CDC9634E21A0';
        $sGroupName      = 'A New Group';
        $sGroupNameSlug  = 'a_new_group';
        $fMaxMultiplier  = null;
        $fMinMultiplier  = null;
        $fMaxModifier    = 5;
        $fMinModifier    = 0.1;
        $iMaxCount       = 1;
        $iOrderMethod    = null;
        $bIsMandatory    = true;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroup($oGateway,$oLogger);
      
       
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sGroupName         = $sGroupName;
        $oEntity->sGroupNameSlug     = $sGroupNameSlug;  
        $oEntity->fMaxMultiplier     = $fMaxMultiplier;
        $oEntity->fMinMultiplier     = $fMinMultiplier;
        $oEntity->fMaxModifier       = $fMaxModifier;
        $oEntity->fMinModifier       = $fMinModifier;
        $oEntity->iMaxCount          = $iMaxCount;
        $oEntity->iOrderMethod       = $iOrderMethod;
        $oEntity->bIsMandatory       = $bIsMandatory;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new AdjustmentGroup Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(6,$oEntity->iEpisodeID);

        
    } 
    
  
    protected function entityUpdateExistingEpisodeTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId       = 4;   
        $sAdjRuleGroupId = '634539B7-AB03-2DF7-67D6-2A7A5AF0BDF3';
        $sGroupName      = 'Is Updated';
        $sGroupNameSlug  = 'is_updated';
        $fMaxMultiplier  = null;
        $fMinMultiplier  = null;
        $fMaxModifier    = 5;
        $fMinModifier    = 0.1;
        $iMaxCount       = 1;
        $iOrderMethod    = null;
        $bIsMandatory    = true;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroup($oGateway,$oLogger);
      
        $oEntity->iEpisodeID         = $iEpisodeId;  
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sGroupName         = $sGroupName;
        $oEntity->sGroupNameSlug     = $sGroupNameSlug;  
        $oEntity->fMaxMultiplier     = $fMaxMultiplier;
        $oEntity->fMinMultiplier     = $fMinMultiplier;
        $oEntity->fMaxModifier       = $fMaxModifier;
        $oEntity->fMinModifier       = $fMinModifier;
        $oEntity->iMaxCount          = $iMaxCount;
        $oEntity->iOrderMethod       = $iOrderMethod;
        $oEntity->bIsMandatory       = $bIsMandatory;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing AdjustmentGroup Episode',$aResult['msg']);
        $this->assertTrue($bResult);
       
        
        
    }
    
    protected function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 5;   
        $sAdjRuleGroupId = 'EF82C808-2F84-62C3-1534-E5AFDF7DCDCB';
        $sGroupName      = 'Is New Version';
        $sGroupNameSlug  = 'is_new_version';
        $fMaxMultiplier  = 200;
        $fMinMultiplier  = 100;
        $fMaxModifier    = 5;
        $fMinModifier    = 0.1;
        $iMaxCount       = 1;
        $iOrderMethod    = null;
        $bIsMandatory    = true;
        $oEnabledFrom    = (new DateTime('now -1 day'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroup($oGateway,$oLogger);
      
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sGroupName         = $sGroupName;
        $oEntity->sGroupNameSlug     = $sGroupNameSlug;  
        $oEntity->fMaxMultiplier     = $fMaxMultiplier;
        $oEntity->fMinMultiplier     = $fMinMultiplier;
        $oEntity->fMaxModifier       = $fMaxModifier;
        $oEntity->fMinModifier       = $fMinModifier;
        $oEntity->iMaxCount          = $iMaxCount;
        $oEntity->iOrderMethod       = $iOrderMethod;
        $oEntity->bIsMandatory       = $bIsMandatory;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new AdjustmentGroup Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(7,$oEntity->iEpisodeID);
        
    }
    
     protected function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
      
       $iEpisodeId      = null;   
        $sAdjRuleGroupId = 'BFB63A44-5FB4-BA2F-EF52-CDC9634E21A0';
        $sGroupName      = 'A New Group';
        $sGroupNameSlug  = 'a_new_group';
        $fMaxMultiplier  = null;
        $fMinMultiplier  = null;
        $fMaxModifier    = 5;
        $fMinModifier    = 0.1;
        $iMaxCount       = 1;
        $iOrderMethod    = null;
        $bIsMandatory    = true;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroup($oGateway,$oLogger);
      
       $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sGroupName         = $sGroupName;
        $oEntity->sGroupNameSlug     = $sGroupNameSlug;  
        $oEntity->fMaxMultiplier     = $fMaxMultiplier;
        $oEntity->fMinMultiplier     = $fMinMultiplier;
        $oEntity->fMaxModifier       = $fMaxModifier;
        $oEntity->fMinModifier       = $fMinModifier;
        $oEntity->iMaxCount          = $iMaxCount;
        $oEntity->iOrderMethod       = $iOrderMethod;
        $oEntity->bIsMandatory       = $bIsMandatory;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check AdjustmentGroup,RuleChain',$aResult['msg']);
        $this->assertFalse($bResult);
        
    }
    
    
    protected function entityCreateFailsOnFKTest()
    {
        // no keys to check yet
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 3;   
        $sAdjRuleGroupId = '1A44C9FC-B7FA-0EFE-4F1D-7952A6BA7A60';
        $sGroupName      = 'Can be closed';
        $sGroupNameSlug  = 'can_be_closed';
        $fMaxMultiplier  = null;
        $fMinMultiplier  = null;
        $fMaxModifier    = 5;
        $fMinModifier    = 0.1;
        $iMaxCount       = 1;
        $iOrderMethod    = null;
        $bIsMandatory    = true;
        $oEnabledFrom    = (new DateTime('now - 1 day'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroup($oGateway,$oLogger);
      
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sGroupName         = $sGroupName;
        $oEntity->sGroupNameSlug     = $sGroupNameSlug;  
        $oEntity->fMaxMultiplier     = $fMaxMultiplier;
        $oEntity->fMinMultiplier     = $fMinMultiplier;
        $oEntity->fMaxModifier       = $fMaxModifier;
        $oEntity->fMinModifier       = $fMinModifier;
        $oEntity->iMaxCount          = $iMaxCount;
        $oEntity->iOrderMethod       = $iOrderMethod;
        $oEntity->bIsMandatory       = $bIsMandatory;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this AdjustmentGroup episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */