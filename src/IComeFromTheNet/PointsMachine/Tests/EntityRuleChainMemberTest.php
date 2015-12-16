<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\RuleChainMember;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use DBALGateway\Feature\BufferedQueryLogger;


class EntityRuleChainMemberTest extends TestWithContainer
{
    
    protected $aFixtures = ['example-system.php','rule-chain-member-before.php'];
    
    
    
    
    public function testEntityOperations()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        
        $oExpectedDataset = $this->getDataSet( ['example-system.php','rule-chain-member-after.php'])
                                 ->getTable('pt_chain_member');
                                 
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oGateway->getAdapater()->getConfiguration()->setSQLLogger($oLog);
            
        $this->entitySaveNewEntityTest();
        $this->entitySaveFailedWhenNonCurrentEpisode();
        $this->entityUpdateExistingEpisodeTest();
        $this->entityUpdateCauseNewVersionTest();
        $this->entityCreateFailsOnFKTest();
        $this->entityRemoveFailsOnRelationsKeyCheckTest();
        $this->entityRemoveSucessfulTest();
        
        $sSql  = ' SELECT episode_id, chain_member_id, rule_chain_id, rule_group_id, ';
        $sSql .= '       order_seq, enabled_from, enabled_to  ' ;
        $sSql .= ' FROM pt_chain_member';
        
        $this->assertTablesEqual($this->getConnection()->createQueryTable('pt_chain_member',$sSql),$oExpectedDataset);
    }
    
    //--------------------------------------------------------------------------
    # Database Operations
    
    protected function entitySaveNewEntityTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        $sChainMemberId  = '98E570E7-A497-8236-58A6-0F8EB2C2939B';
        $sRuleChainId    = '78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5';
        $sAdjRuleGroupId = '586DB7DF-57C3-F7D5-639D-0A9779AF79BD';
        $iOrderSeq       = 2;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new RuleChainMember($oGateway,$oLogger);
      
        $oEntity->sRuleChainMemberID = $sChainMemberId;
        $oEntity->sRuleChainID   = $sRuleChainId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->iOrderSeq = $iOrderSeq;
        $oEntity->oEnabledFrom  = $oEnabledFrom;
        $oEntity->oEnabledTo    = $oEnabledTo ;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new RuleChainMember Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(7,$oEntity->iEpisodeID);

        
    } 
    
    protected function entitySaveFailedWhenNonCurrentEpisode()
    {
        
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sChainMemberId  = '11A09C6D-C851-5874-8667-72BE94DD1A47';
        $sRuleChainId    = '78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5';
        $sAdjRuleGroupId = '586DB7DF-57C3-F7D5-639D-0A9779AF79BD';
        $iOrderSeq       = 2;
        $oEnabledFrom    = (new DateTime('now - 7 day'));
        $oEnabledTo      = (new DateTime('now - 1 day'));
      
        
        $oEntity = new RuleChainMember($oGateway,$oLogger);
      
        $oEntity->sRuleChainMemberID = $sChainMemberId;
        $oEntity->sRuleChainID   = $sRuleChainId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->iOrderSeq = $iOrderSeq;
        $oEntity->oEnabledFrom  = $oEnabledFrom;
        $oEntity->oEnabledTo    = $oEnabledTo ;
        $oEntity->iEpisodeID    = 3;
      
        
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
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sChainMemberId  = 'DB02441C-EBDC-7C79-AFF9-353402F9DB04';
        $sRuleChainId    = '78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5';
        $sAdjRuleGroupId = '586DB7DF-57C3-F7D5-639D-0A9779AF79BD';
        $iOrderSeq       = 7;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new RuleChainMember($oGateway,$oLogger);
      
        $oEntity->sRuleChainMemberID = $sChainMemberId;
        $oEntity->sRuleChainID   = $sRuleChainId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->iOrderSeq = $iOrderSeq;
        $oEntity->oEnabledFrom  = $oEnabledFrom;
        $oEntity->oEnabledTo    = $oEnabledTo ;
        $oEntity->iEpisodeID    = 4;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Updated existing RuleChainMember Episode',$aResult['msg']);
        $this->assertTrue($bResult);
       
        
        
    }
    
    protected function entityUpdateCauseNewVersionTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sChainMemberId  = '1D7A2FC4-E1F0-5BCE-F2AB-93AF302BCEFA';
        $sRuleChainId    = '78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5';
        $sAdjRuleGroupId = '586DB7DF-57C3-F7D5-639D-0A9779AF79BD';
        $iOrderSeq       = 8;
        $oEnabledFrom    = (new DateTime('now - 1 day'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new RuleChainMember($oGateway,$oLogger);
      
        $oEntity->sRuleChainMemberID = $sChainMemberId;
        $oEntity->sRuleChainID   = $sRuleChainId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->iOrderSeq = $iOrderSeq;
        $oEntity->oEnabledFrom  = $oEnabledFrom;
        $oEntity->oEnabledTo    = $oEnabledTo ;
        $oEntity->iEpisodeID    = 5;
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Created new RuleChainMember Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        $this->assertEquals(8,$oEntity->iEpisodeID);
        
    }
    
     protected function entityCreateFailsOnFKTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
      
        $sChainMemberId  = 'A8561585-9AC4-BD0B-8C2F-52164B7E3E1C';
        $sRuleChainId    = 'CDB50A01-F629-4809-2A06-A44813709925'; // non current rule chain
        $sAdjRuleGroupId = 'A94BB0F5-6568-EAF7-E7D9-FAE0D861496B'; // non current adj rule group
        $iOrderSeq       = 8;
       
        
        $oEntity = new RuleChainMember($oGateway,$oLogger);
      
        $oEntity->sRuleChainMemberID = $sChainMemberId;
        $oEntity->sRuleChainID   = $sRuleChainId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->iOrderSeq = $iOrderSeq;
        
        
        // save the entity
        $bResult = $oEntity->save();
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertFalse($aResult['result']);
        $this->assertEquals('Temporal Referential integrity violated check AdjustmentGroup,RuleChain',$aResult['msg']);
        $this->assertFalse($bResult);
        
    }
    
    
    protected function entityRemoveFailsOnRelationsKeyCheckTest()
    {
        // no keys to check yet
    }
    
    protected function entityRemoveSucessfulTest()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
         $sChainMemberId  = '824DF964-D106-5704-58CD-86E51620B803';
        $sRuleChainId    = '78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5';
        $sAdjRuleGroupId = '586DB7DF-57C3-F7D5-639D-0A9779AF79BD';
        $iOrderSeq       = 2;
        $oEnabledFrom    = (new DateTime('now'));
        $oEnabledTo      = (new DateTime('3000-01-01'));
      
        
        $oEntity = new RuleChainMember($oGateway,$oLogger);
      
        $oEntity->sRuleChainMemberID = $sChainMemberId;
        $oEntity->sRuleChainID   = $sRuleChainId;
        $oEntity->sAdjustmentGroupID = $sAdjRuleGroupId;
        $oEntity->iOrderSeq = $iOrderSeq;
        $oEntity->oEnabledFrom  = $oEnabledFrom;
        $oEntity->oEnabledTo    = $oEnabledTo ;
        $oEntity->iEpisodeID    = 6;
        
        
        // save the entity
        $bResult = $oEntity->remove();
        $aResult = $oEntity->getLastQueryResult();
      
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Closed this RuleChainMember episode',$aResult['msg']);
        $this->assertTrue($bResult);
    }
       
    
}
/* End of File */