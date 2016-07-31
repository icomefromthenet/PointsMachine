<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroupLimit;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;


class EntityAdjGroupLimitTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','adj-group-limit-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','adj-group-limit-after.php'])
                                 ->getTable('pt_rule_group_limits');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        //$this->entityCreateFailsOnFKTest();
        
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        
        $this->entityRemoveSucessfulTest();
        
        $sSql  = ' SELECT episode_id, rule_group_id, score_group_id, system_id, enabled_from, enabled_to  ' ;
        $sSql .= ' FROM pt_rule_group_limits';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_rule_group_limits',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $iEpisodeId      = null;   
        $sAdjRuleGroupId = '77CE8E53-5463-8174-614F-5865A9D040A3';
        $sScoreGroupId   = null;
        $sSystemId       = '82F02AAA-DA4D-EFCF-B856-EADF6D365824';
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroupLimit($oGateway,$oLogger);
      
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sScoreGroupID      = $sScoreGroupId;
        $oEntity->sSystemID          = $sSystemId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new AdjustmentGroupLimit Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(14,$oEntity->iEpisodeID);

        
    } 
    
  
    protected function entityUpdateExistingEpisodeTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $iEpisodeId      = 12;   
        $sAdjRuleGroupId = '77CE8E53-5463-8174-614F-5865A9D040A3';
        $sScoreGroupId   = '75175F0F-EA58-146E-C82F-655B7BFD786E';
        $sSystemId       = null;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroupLimit($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sScoreGroupID      = $sScoreGroupId;
        $oEntity->sSystemID          = $sSystemId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing AdjustmentGroupLimit Episode',$aResult['msg']);
        $this->assertTrue($bResult);
       
        
        
    }
    
    protected function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 13;   
        $sAdjRuleGroupId = 'FB104354-BB12-CD1D-02CA-40EBE222F2E7';
        $sScoreGroupId   = '0373AA53-BEAF-534D-D943-EFD40F6F0CC1';
        $sSystemId       = null;
        $oEnabledFrom    = (new DateTime('now - 1 day'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroupLimit($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sScoreGroupID      = $sScoreGroupId;
        $oEntity->sSystemID          = $sSystemId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new AdjustmentGroupLimit Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(15,$oEntity->iEpisodeID);
        
    }
    
     protected function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
      
        $iEpisodeId      = null;   
        $sAdjRuleGroupId = 'D1E9AFFC-519C-807C-9EF1-3841359EF250'; // expired group
        $sScoreGroupId   = '489F52A7-26DF-311A-F651-2EE6D0380A48'; //expired score group
        $sSystemId       = 'A9BE3A0B-B93F-ACC7-8811-A4554A3CEB79'; //expired system
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroupLimit($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sScoreGroupID      = $sScoreGroupId;
        $oEntity->sSystemID          = $sSystemId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check AdjustmentRuleGroup,System,ScoreGroup',$aResult['msg']);
        $this->assertFalse($bResult);
        
    }
    
    
    protected function entityCreateFailsOnFKTest()
    {
        // no keys to check yet
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $iEpisodeId      = 11;   
        $sAdjRuleGroupId = 'FB104354-BB12-CD1D-02CA-40EBE222F2E7';
        $sScoreGroupId   = '75175F0F-EA58-146E-C82F-655B7BFD786E';
        $sSystemId       = '82F02AAA-DA4D-EFCF-B856-EADF6D365824';
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new AdjustmentGroupLimit($oGateway,$oLogger);
      
       
        $oEntity->iEpisodeID         = $iEpisodeId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->sScoreGroupID      = $sScoreGroupId;
        $oEntity->sSystemID          = $sSystemId;
        $oEntity->oEnabledFrom       = $oEnabledFrom;
        $oEntity->oEnabledTo         = $oEnabledTo;
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this AdjustmentGroupLimit episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */