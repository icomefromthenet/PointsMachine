<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\PointsSystem;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;

class BuilderTest extends TestWithContainer
{
    
    public function getDataSet()
    {
       return new ArrayDataSet();
    }
    
    public function testPointSystemBuilder()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_system')
                         ->getEntityBuilder();
        
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlias.'episode_id' => 1,
            $sAlias.'system_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlias.'system_name' => 'Demo A',
            $sAlias.'system_name_slug' => 'demo_a',
            $sAlias.'enabled_from' => new DateTime(),
            $sAlias.'enabled_to' => new DateTime('3000-01-01'),
        );
        
        $oPointsSystem = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oPointsSystem->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlias.'system_id'],$oPointsSystem->sSystemID);
        $this->assertEquals($aRawEntity[$sAlias.'system_name'],$oPointsSystem->sSystemName);
        $this->assertEquals($aRawEntity[$sAlias.'system_name_slug'],$oPointsSystem->sSystemNameSlug);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oPointsSystem->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oPointsSystem->oEnabledTo);
        
        
        # test demolish
        
        $aRawEntity = $oBuilder->demolish($oPointsSystem);
        
        $this->assertEquals($oPointsSystem->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oPointsSystem->sSystemID,$aRawEntity['system_id']);
        $this->assertEquals($oPointsSystem->sSystemName,$aRawEntity['system_name']);
        $this->assertEquals($oPointsSystem->sSystemNameSlug,$aRawEntity['system_name_slug']);
        $this->assertEquals($oPointsSystem->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oPointsSystem->oEnabledTo,$aRawEntity['enabled_to']);
        
    }
    
    
    public function  testPointSystemZone()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_system_zone')
                         ->getEntityBuilder();
        
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlias.'episode_id' => 1,
            $sAlias.'system_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlias.'zone_id' =>  'ACAAF45C-FE62-909B-5CCD-3D967F3F8531',
            $sAlias.'zone_name' => 'Demo Zone A',
            $sAlias.'zone_name_slug' => 'demo_zone_a',
            $sAlias.'enabled_from' => new DateTime(),
            $sAlias.'enabled_to' => new DateTime('3000-01-01'),
            'system_name'        => 'system1',
        );
        
        $oPointsSystemZone = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oPointsSystemZone->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlias.'system_id'],$oPointsSystemZone->sSystemID);
        $this->assertEquals($aRawEntity[$sAlias.'zone_id'],$oPointsSystemZone->sZoneID);
        $this->assertEquals($aRawEntity[$sAlias.'zone_name'],$oPointsSystemZone->sZoneName);
        $this->assertEquals($aRawEntity[$sAlias.'zone_name_slug'],$oPointsSystemZone->sZoneNameSlug);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oPointsSystemZone->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oPointsSystemZone->oEnabledTo);
        
        $this->assertEquals($aRawEntity['system_name'],$oPointsSystemZone->sSystemName);
        
        # test demolish
        
        $aRawEntity = $oBuilder->demolish($oPointsSystemZone);
        
        $this->assertEquals($oPointsSystemZone->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oPointsSystemZone->sSystemID,$aRawEntity['system_id']);
        $this->assertEquals($oPointsSystemZone->sZoneID,$aRawEntity['zone_id']);
        $this->assertEquals($oPointsSystemZone->sZoneName,$aRawEntity['zone_name']);
        $this->assertEquals($oPointsSystemZone->sZoneNameSlug,$aRawEntity['zone_name_slug']);
        $this->assertEquals($oPointsSystemZone->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oPointsSystemZone->oEnabledTo,$aRawEntity['enabled_to']);
        $this->assertEquals($oPointsSystemZone->sSystemName,$aRawEntity['system_name']);
        
       
    }
    
    
    public function testScoreGroupBuilder()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_score_group')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlias.'episode_id'    => 1,
            $sAlias.'score_group_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlias.'group_name' => 'Demo Event A',
            $sAlias.'group_name_slug' => 'demo_event_a',
            $sAlias.'enabled_from' => new DateTime(),
            $sAlias.'enabled_to' => new DateTime('3000-01-01'),
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlias.'score_group_id'],$oEntity->sScoreGroupID);
        $this->assertEquals($aRawEntity[$sAlias.'group_name'],$oEntity->sGroupName);
        $this->assertEquals($aRawEntity[$sAlias.'group_name_slug'],$oEntity->sGroupNameSlug);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
    
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oEntity->sScoreGroupID,$aRawEntity['score_group_id']);
        $this->assertEquals($oEntity->sGroupName,$aRawEntity['group_name']);
        $this->assertEquals($oEntity->sGroupNameSlug,$aRawEntity['group_name_slug']);
        $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
        
        
    }
    
    public function testScoreBuilder()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_score')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlias.'episode_id'      => 1,
            $sAlias.'score_id'        => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'score_group_id'  => '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlias.'score_name'      => 'Demo Score A',
            $sAlias.'score_name_slug' => 'demo_score_a',
            $sAlias.'score_value'     => 100,
            $sAlias.'enabled_from'    => new DateTime(),
            $sAlias.'enabled_to'      => new DateTime('3000-01-01'),
            'score_group_name'        => 'scoregroup1',
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlias.'score_id'],$oEntity->sScoreID);
        $this->assertEquals($aRawEntity[$sAlias.'score_group_id'],$oEntity->sScoreGroupID);
        $this->assertEquals($aRawEntity[$sAlias.'score_name'],$oEntity->sScoreName);
        $this->assertEquals($aRawEntity[$sAlias.'score_name_slug'],$oEntity->sScoreNameSlug);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
        $this->assertEquals($aRawEntity[$sAlias.'score_value'],$oEntity->fScoreValue);
        $this->assertEquals($aRawEntity['score_group_name'],$oEntity->sScoreGroupName);
        
        
    
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oEntity->sScoreID,$aRawEntity['score_id']);
        $this->assertEquals($oEntity->sScoreGroupID,$aRawEntity['score_group_id']);
        $this->assertEquals($oEntity->sScoreName,$aRawEntity['score_name']);
        $this->assertEquals($oEntity->sScoreNameSlug,$aRawEntity['score_name_slug']);
        $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        $this->assertEquals($oEntity->sScoreGroupName,$aRawEntity['score_group_name']);
        
        
        
        
    }
    
    public function testRuleChainBuilder()
    {
          $oBuilder = $this->getContainer()
                          ->getGatewayCollection()
                          ->getGateway('pt_rule_chain')
                          ->getEntityBuilder();
      
         $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
         # test build
        
         $aRawEntity = array(
             $sAlias.'episode_id'      => 1,
             $sAlias.'rule_chain_id'   =>  'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlias.'event_type_id'   =>  'H5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlias.'system_id'       =>  'I5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlias.'chain_name'      => 'Chain A',
             $sAlias.'chain_name_slug' => 'chain_a',
             $sAlias.'rounding_option' => 2,
             $sAlias.'cap_value'       => 100,
             $sAlias.'enabled_from'    => new DateTime(),
             $sAlias.'enabled_to'      => new DateTime('3000-01-01'),
             'system_name'             => 'systemA',
             'event_name'              => 'eventA',
         );
        
         $oEntity = $oBuilder->build($aRawEntity);
        
         $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
         $this->assertEquals($aRawEntity[$sAlias.'rule_chain_id'],$oEntity->sRuleChainID);
         $this->assertEquals($aRawEntity[$sAlias.'event_type_id'],$oEntity->sEventTypeID);
         $this->assertEquals($aRawEntity[$sAlias.'system_id'],$oEntity->sSystemID);
         $this->assertEquals($aRawEntity[$sAlias.'chain_name'],$oEntity->sChainName);
         $this->assertEquals($aRawEntity[$sAlias.'chain_name_slug'],$oEntity->sChainNameSlug);
         $this->assertEquals($aRawEntity[$sAlias.'rounding_option'],$oEntity->iRoundingOption);
         $this->assertEquals($aRawEntity[$sAlias.'cap_value'],$oEntity->fCapValue);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
         $this->assertEquals($aRawEntity['system_name'],$oEntity->sSystemName);
         $this->assertEquals($aRawEntity['event_name'],$oEntity->sEventTypeName);
        
        
         $aRawEntity = $oBuilder->demolish($oEntity);
        
         $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
         $this->assertEquals($oEntity->sRuleChainID,$aRawEntity['rule_chain_id']);
         $this->assertEquals($oEntity->sEventTypeID,$aRawEntity['event_type_id']);
         $this->assertEquals($oEntity->sSystemID,$aRawEntity['system_id']);
         $this->assertEquals($oEntity->sChainName,$aRawEntity['chain_name']);
         $this->assertEquals($oEntity->sChainNameSlug,$aRawEntity['chain_name_slug']);
         $this->assertEquals($oEntity->iRoundingOption,$aRawEntity['rounding_option']);
         $this->assertEquals($oEntity->fCapValue,$aRawEntity['cap_value']);
         $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
         $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
         $this->assertEquals($oEntity->sSystemName,$aRawEntity['system_name']);
         $this->assertEquals($oEntity->sEventTypeName,$aRawEntity['event_name']);
       
        
     }
     
    public function testRuleChainMemberBuilder()
    {
          $oBuilder = $this->getContainer()
                          ->getGatewayCollection()
                          ->getGateway('pt_chain_member')
                          ->getEntityBuilder();
      
         $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
         # test build
        
         $aRawEntity = array(
             $sAlias.'episode_id'      => 1,
             $sAlias.'chain_member_id' =>  'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlias.'rule_chain_id'   =>  'H5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlias.'rule_group_id'   =>  'I5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlias.'order_seq'       => 2,
             $sAlias.'enabled_from'    => new DateTime(),
             $sAlias.'enabled_to'      => new DateTime('3000-01-01'),
             
             'rule_group_name'               => 'Rule1',
             'chain_name'              => 'Chain1',
         );
        
         $oEntity = $oBuilder->build($aRawEntity);
        
         $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
         $this->assertEquals($aRawEntity[$sAlias.'rule_chain_id'],$oEntity->sRuleChainID);
         $this->assertEquals($aRawEntity[$sAlias.'chain_member_id'],$oEntity->sRuleChainMemberID);
         $this->assertEquals($aRawEntity[$sAlias.'rule_group_id'],$oEntity->sAdjustmentGroupID);
         $this->assertEquals($aRawEntity[$sAlias.'order_seq'],$oEntity->iOrderSeq);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
         $this->assertEquals($aRawEntity['rule_group_name'],$oEntity->sAdjustmentGroupName);
         $this->assertEquals($aRawEntity['chain_name'],$oEntity->sRuleChainName);
        
        
         $aRawEntity = $oBuilder->demolish($oEntity);
        
         $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
         $this->assertEquals($oEntity->sRuleChainID,$aRawEntity['rule_chain_id']);
         $this->assertEquals($oEntity->sRuleChainMemberID,$aRawEntity['chain_member_id']);
         $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
         $this->assertEquals($oEntity->iOrderSeq,$aRawEntity['order_seq']);
         $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
         $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
         $this->assertEquals($oEntity->sAdjustmentGroupName,$aRawEntity['rule_group_name']);
         $this->assertEquals($oEntity->sRuleChainName,$aRawEntity['chain_name']);
       
        
     }
    
    
     public function testEventTypesBuilder()
     {
         $oBuilder = $this->getContainer()
                          ->getGatewayCollection()
                          ->getGateway('pt_event_type')
                          ->getEntityBuilder();
      
         $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
         # test build
        
         $aRawEntity = array(
             $sAlias.'episode_id' => 1,
             $sAlias.'event_type_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
             $sAlias.'event_name' => 'Demo Event A',
             $sAlias.'event_name_slug' => 'demo_event_a',
             $sAlias.'enabled_from' => new DateTime(),
             $sAlias.'enabled_to' => new DateTime('3000-01-01'),
         );
        
         $oEntity = $oBuilder->build($aRawEntity);
        
         $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
         $this->assertEquals($aRawEntity[$sAlias.'event_type_id'],$oEntity->sEventTypeID);
         $this->assertEquals($aRawEntity[$sAlias.'event_name'],$oEntity->sEventName);
         $this->assertEquals($aRawEntity[$sAlias.'event_name_slug'],$oEntity->sEventNameSlug);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
    
         $aRawEntity = $oBuilder->demolish($oEntity);
        
         $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
         $this->assertEquals($oEntity->sEventTypeID,$aRawEntity['event_type_id']);
         $this->assertEquals($oEntity->sEventName,$aRawEntity['event_name']);
         $this->assertEquals($oEntity->sEventNameSlug,$aRawEntity['event_name_slug']);
         $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
         $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
        
    }
    
    public function testEventBuilder()    
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_event')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlias.'event_id'      => 1,
            $sAlias.'event_type_id' => '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlias.'process_date'  => new DateTime('now +5 day'),
            $sAlias.'occured_date'  => new DateTime('now -10 day'),
    
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'event_id'],$oEntity->iScoringEventID);
        $this->assertEquals($aRawEntity[$sAlias.'event_type_id'],$oEntity->sEventTypeID);
        $this->assertEquals($aRawEntity[$sAlias.'process_date'],$oEntity->oProcessDate);
        $this->assertEquals($aRawEntity[$sAlias.'occured_date'],$oEntity->oOccuredDate);
    
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
        $this->assertEquals($oEntity->sEventTypeID,$aRawEntity['event_type_id']);
        $this->assertEquals($oEntity->oProcessDate,$aRawEntity['process_date']);
        $this->assertEquals($oEntity->oOccuredDate,$aRawEntity['occured_date']);
    
        
    }
    
    
    

    public function testAdjustmentGroupBuilder()
    {
        
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_rule_group')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlias.'episode_id'           => 1,
            $sAlias.'rule_group_id'        => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'rule_group_name'      => 'Scoring Group A',
            $sAlias.'rule_group_name_slug' => 'scoring_group_a',
            $sAlias.'max_multiplier'       => 100,
            $sAlias.'min_multiplier'       => 1,
            $sAlias.'max_modifier'         => 200,
            $sAlias.'min_modifier'         => 2,
            $sAlias.'max_count'            => 5,
            $sAlias.'order_method'         => 1,
            $sAlias.'is_mandatory'         => 1,
            $sAlias.'enabled_from'         => new DateTime(),
            $sAlias.'enabled_to'           => new DateTime('3000-01-01'),
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlias.'rule_group_id'],$oEntity->sAdjustmentGroupID);
        $this->assertEquals($aRawEntity[$sAlias.'rule_group_name'],$oEntity->sGroupName);
        $this->assertEquals($aRawEntity[$sAlias.'rule_group_name_slug'],$oEntity->sGroupNameSlug);
        $this->assertEquals($aRawEntity[$sAlias.'max_multiplier'],$oEntity->fMaxMultiplier);
        $this->assertEquals($aRawEntity[$sAlias.'min_multiplier'],$oEntity->fMinMultiplier);
        $this->assertEquals($aRawEntity[$sAlias.'max_modifier'],$oEntity->fMaxModifier);
        $this->assertEquals($aRawEntity[$sAlias.'min_modifier'],$oEntity->fMinModifier);
        $this->assertEquals($aRawEntity[$sAlias.'max_count'],$oEntity->iMaxCount);
        $this->assertEquals($aRawEntity[$sAlias.'order_method'],$oEntity->iOrderMethod);
        $this->assertTrue($oEntity->bIsMandatory);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
        
        
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
        $this->assertEquals($oEntity->sGroupName,$aRawEntity['rule_group_name']);
        $this->assertEquals($oEntity->sGroupNameSlug,$aRawEntity['rule_group_name_slug']);
        $this->assertEquals($oEntity->fMaxMultiplier,$aRawEntity['max_multiplier']);
        $this->assertEquals($oEntity->fMinMultiplier,$aRawEntity['min_multiplier']);
        $this->assertEquals($oEntity->fMaxModifier,$aRawEntity['max_modifier']);
        $this->assertEquals($oEntity->fMinModifier,$aRawEntity['min_modifier']);
        $this->assertEquals($oEntity->iMaxCount,$aRawEntity['max_count']);
        $this->assertEquals($oEntity->iOrderMethod,$aRawEntity['order_method']);
        $this->assertEquals($oEntity->bIsMandatory,$aRawEntity['is_mandatory']);
        $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
        
        
    }
    
     public function testAdjustmentGroupLimitBuilder()
     {
        
         $oBuilder = $this->getContainer()
                          ->getGatewayCollection()
                          ->getGateway('pt_rule_group_limits')
                          ->getEntityBuilder();
      
         $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
         # test build
        
         $aRawEntity = array(
            $sAlias.'episode_id'           => 1,
            $sAlias.'rule_group_id'        => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'score_group_id'       => 'K5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'system_id'            => 'L5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'enabled_from'         => new DateTime(),
            $sAlias.'enabled_to'           => new DateTime('3000-01-01'),
            'rule_group_name'              => 'rulegroup1',
            'score_group_name'             => 'scoregroup1',
            'system_name'                  => 'system1'
         );
        
         $oEntity = $oBuilder->build($aRawEntity);
        
         $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
         $this->assertEquals($aRawEntity[$sAlias.'rule_group_id'],$oEntity->sAdjustmentGroupID);
         $this->assertEquals($aRawEntity[$sAlias.'score_group_id'],$oEntity->sScoreGroupID);
         $this->assertEquals($aRawEntity[$sAlias.'system_id'],$oEntity->sSystemID);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
         $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
        
         $this->assertEquals($aRawEntity['rule_group_name'],$oEntity->sAdjustmentGroupName);
         $this->assertEquals($aRawEntity['score_group_name'],$oEntity->sScoreGroupName);
         $this->assertEquals($aRawEntity['system_name'],$oEntity->sPointSystemName);
        
        
         $aRawEntity = $oBuilder->demolish($oEntity);
        
         $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
         $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
         $this->assertEquals($oEntity->sScoreGroupID,$aRawEntity['score_group_id']);
         $this->assertEquals($oEntity->sSystemID,$aRawEntity['system_id']);
         $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
         $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
         
         $this->assertEquals($oEntity->sAdjustmentGroupName, $aRawEntity['rule_group_name']);
         $this->assertEquals($oEntity->sScoreGroupName, $aRawEntity['score_group_name']);
         $this->assertEquals($oEntity->sPointSystemName, $aRawEntity['system_name']);
        
        
        
     }
    
    public function testAdjustmentRuleBuilder()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_rule')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlias.'episode_id'      => 1,
            $sAlias.'rule_id'         => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'rule_group_id'   => 'C5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'rule_name'       => 'Demo Adj Rule',
            $sAlias.'rule_name_slug'  => 'demo_adj_rule',
            $sAlias.'multiplier'      => 1.5,
            $sAlias.'modifier'        => 10.00,
            $sAlias.'invert_flag'     => 1,
            $sAlias.'enabled_from'    => new DateTime(),
            $sAlias.'enabled_to'      => new DateTime('3000-01-01'),
            'rule_group_name'         => 'rulegroup1',
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlias.'rule_id'],$oEntity->sAdjustmentRuleID);
        $this->assertEquals($aRawEntity[$sAlias.'rule_group_id'],$oEntity->sAdjustmentGroupID);
        $this->assertEquals($aRawEntity[$sAlias.'rule_name'],$oEntity->sRuleName);
        $this->assertEquals($aRawEntity[$sAlias.'rule_name_slug'],$oEntity->sRuleNameSlug);
        $this->assertEquals($aRawEntity[$sAlias.'multiplier'],$oEntity->fMultiplier);
        $this->assertEquals($aRawEntity[$sAlias.'modifier'],$oEntity->fModifier);
        $this->assertEquals($aRawEntity[$sAlias.'invert_flag'],(int)$oEntity->bInvertFlag);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
        $this->assertEquals($aRawEntity['rule_group_name'],$oEntity->sAdjustmentGroupName);
        
        
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oEntity->sAdjustmentRuleID,$aRawEntity['rule_id']);
        $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
        $this->assertEquals($oEntity->sRuleName,$aRawEntity['rule_name']);
        $this->assertEquals($oEntity->sRuleNameSlug,$aRawEntity['rule_name_slug']);
        $this->assertEquals($oEntity->fMultiplier,$aRawEntity['multiplier']);
        $this->assertEquals($oEntity->fModifier,$aRawEntity['modifier']);
        $this->assertEquals($oEntity->bInvertFlag,(bool)$aRawEntity['invert_flag']);
        $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        $this->assertEquals($oEntity->sAdjustmentGroupName,$aRawEntity['rule_group_name']);
        
        
    }
    
    public function testAdjustmentZoneBuilder()
    {
         $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_rule_sys_zone')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
        # test build

        $aRawEntity = array(
            $sAlias.'episode_id'      => 1,
            $sAlias.'rule_id'         => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'zone_id'         => 'C5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlias.'enabled_from'    => new DateTime(),
            $sAlias.'enabled_to'      => new DateTime('3000-01-01'),
            'rule_name'               => 'rule1',
            'zone_name'               => 'zone1',
            
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlias.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlias.'rule_id'],$oEntity->sAdjustmentRuleID);
        $this->assertEquals($aRawEntity[$sAlias.'zone_id'],$oEntity->sSystemZoneID);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlias.'enabled_to'],$oEntity->oEnabledTo);
        $this->assertEquals($aRawEntity['rule_name'],$oEntity->sAdjustmentRuleName);
        $this->assertEquals($aRawEntity['zone_name'],$oEntity->sSystemZoneName);
    
    
        
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oEntity->sAdjustmentRuleID,$aRawEntity['rule_id']);
        $this->assertEquals($oEntity->sSystemZoneID,$aRawEntity['zone_id']);
        $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        $this->assertEquals($oEntity->sAdjustmentRuleName,$aRawEntity['rule_name']);
        $this->assertEquals($oEntity->sSystemZoneName,$aRawEntity['zone_name']);
    
        
    }
    
    public function testCalculationEventBuilder()
    {
          $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_transaction_header')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
          $aRawEntity = array(
            $sAlias.'event_id'          => 9,
            $sAlias.'system_ep'         => 6,
            $sAlias.'zone_ep'           => 7,
            $sAlias.'event_type_ep'     => 8,
            $sAlias.'created_date'      => new DateTime(),
            $sAlias.'processing_date'   => new DateTime('now + 1 day'),
            $sAlias.'occured_date'      => new DateTime('now - 5 day'),
            $sAlias.'calrunvalue'       => 100.00,
            $sAlias.'calrunvalue_round' => 100,
            
            'system_name'               => 'system1',
            'zone_name'                 => 'zone1',
            'event_name'                => 'event1',
        
           
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
         
        $this->assertEquals($aRawEntity[$sAlias.'event_id'],$oEntity->iScoringEventID);       
        $this->assertEquals($aRawEntity[$sAlias.'system_ep'],$oEntity->iSystemEP);
        $this->assertEquals($aRawEntity[$sAlias.'zone_ep'],$oEntity->iSystemZoneEP);
        $this->assertEquals($aRawEntity[$sAlias.'event_type_ep'],$oEntity->iEventTypeEP);
        $this->assertEquals($aRawEntity[$sAlias.'created_date'],$oEntity->oCreatedDate);
        $this->assertEquals($aRawEntity[$sAlias.'processing_date'],$oEntity->oProcessingDate);
        $this->assertEquals($aRawEntity[$sAlias.'occured_date'],$oEntity->oOccuredDate);
        $this->assertEquals($aRawEntity[$sAlias.'calrunvalue'],$oEntity->fCalRunValue);
        $this->assertEquals($aRawEntity[$sAlias.'calrunvalue_round'],$oEntity->fCalRunValueRound);
        $this->assertEquals($aRawEntity['system_name'],$oEntity->sSystemName);
        $this->assertEquals($aRawEntity['zone_name'],$oEntity->sSystemZoneName);
        $this->assertEquals($aRawEntity['event_name'],$oEntity->sEventName);
        
         
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
        $this->assertEquals($oEntity->iSystemEP,$aRawEntity['system_ep']);
        $this->assertEquals($oEntity->iSystemZoneEP,$aRawEntity['zone_ep']);
        $this->assertEquals($oEntity->iEventTypeEP,$aRawEntity['event_type_ep']);
        $this->assertEquals($oEntity->oCreatedDate,$aRawEntity['created_date']);
        $this->assertEquals($oEntity->oProcessingDate,$aRawEntity['processing_date']);
        $this->assertEquals($oEntity->oOccuredDate,$aRawEntity['occured_date']);
        $this->assertEquals($oEntity->fCalRunValue, $aRawEntity['calrunvalue']);
        $this->assertEquals($oEntity->fCalRunValueRound, $aRawEntity['calrunvalue_round']);
        $this->assertEquals($oEntity->sSystemName,$aRawEntity['system_name']);
        $this->assertEquals($oEntity->sSystemZoneName,$aRawEntity['zone_name']);
        $this->assertEquals($oEntity->sEventName,$aRawEntity['event_name']);
       
        
         
    }
    
    public function testCalculationScoreBuilder()
    {
          $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_transaction_score')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
          $aRawEntity = array(
            $sAlias.'event_id'          => 9,
            $sAlias.'score_ep'          => 4,
            $sAlias.'score_group_ep'    => 5,
            $sAlias.'score_base'        => 10,
            $sAlias.'score_cal_raw'     => 11,
            $sAlias.'score_cal_capped'  => 13,
            $sAlias.'score_quantity'    => 1,
            'score_name'                => 'score1',    
            'score_group_name'          => 'group1',
            
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
         
        $this->assertEquals($aRawEntity[$sAlias.'event_id'],$oEntity->iScoringEventID);   
        $this->assertEquals($aRawEntity[$sAlias.'score_ep'],$oEntity->iScoreEP);
        $this->assertEquals($aRawEntity[$sAlias.'score_group_ep'],$oEntity->iScoreGroupEP);
        $this->assertEquals($aRawEntity[$sAlias.'score_base'],$oEntity->fScoreBase);
        $this->assertEquals($aRawEntity[$sAlias.'score_cal_raw'],$oEntity->fScoreCalRaw);
        $this->assertEquals($aRawEntity[$sAlias.'score_cal_capped'],$oEntity->fScoreCalCapped);
        $this->assertEquals($aRawEntity[$sAlias.'score_quantity'], $oEntity->iScoreQuantity);
        $this->assertEquals($aRawEntity['score_name'],$oEntity->sScoreName);
        $this->assertEquals($aRawEntity['score_group_name'], $oEntity->sScoreGroupName);
        
        
        
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
        $this->assertEquals($oEntity->iScoreEP,$aRawEntity['score_ep']);
        $this->assertEquals($oEntity->iScoreGroupEP,$aRawEntity['score_group_ep']);
        $this->assertEquals($oEntity->fScoreBase,$aRawEntity['score_base']);
        $this->assertEquals($oEntity->fScoreCalRaw,$aRawEntity['score_cal_raw']);
        $this->assertEquals($oEntity->fScoreCalCapped,$aRawEntity['score_cal_capped']);
        $this->assertEquals($oEntity->iScoreQuantity, $aRawEntity['score_quantity']); 
        $this->assertEquals($oEntity->sScoreName, $aRawEntity['score_name']); 
        $this->assertEquals($oEntity->sScoreGroupName, $aRawEntity['score_group_name']); 
         
    }
    
    public function testCalculationAdjRuleBuilder()
    {
      $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_transaction_rule')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
         $aRawEntity = array(
            $sAlias.'event_id'          => 9,
            $sAlias.'score_ep'          => 4,
            $sAlias.'rule_ep'           => 2,
            $sAlias.'rule_group_ep'     => 1,
            $sAlias.'score_modifier'    => 8,
            $sAlias.'score_multiplier'  => 1.5,
            $sAlias.'order_seq'         => 1,
            
            'score_name'               => 'score1',
            'rule_name'                => 'rule1',
            'rule_group_name'          => 'rulegroup1'
           
        );
        
         $oEntity = $oBuilder->build($aRawEntity);
         
           
        $this->assertEquals($aRawEntity[$sAlias.'event_id'],$oEntity->iScoringEventID);
        $this->assertEquals($aRawEntity[$sAlias.'score_ep'],$oEntity->iScoreEP);
        $this->assertEquals($aRawEntity[$sAlias.'rule_ep'],$oEntity->iAdjustmentRuleEP);
        $this->assertEquals($aRawEntity[$sAlias.'score_modifier'],$oEntity->fScoreModifier);
        $this->assertEquals($aRawEntity[$sAlias.'score_multiplier'],$oEntity->fScoreMultiplier);
        $this->assertEquals($aRawEntity[$sAlias.'order_seq'],$oEntity->iOrderSeq);
        $this->assertEquals($aRawEntity[$sAlias.'rule_group_ep'],$oEntity->iAdjustmentGroupEP);
        
        $this->assertEquals($aRawEntity['score_name'],$oEntity->sScoreName);
        $this->assertEquals($aRawEntity['rule_name'],$oEntity->sAdjustmentRuleName);
        $this->assertEquals($aRawEntity['rule_group_name'],$oEntity->sAdjustmentGroupName);
        
        
         $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
        $this->assertEquals($oEntity->iAdjustmentRuleEP,$aRawEntity['rule_ep']);
        $this->assertEquals($oEntity->iScoreEP,$aRawEntity['score_ep']);
        $this->assertEquals($oEntity->fScoreModifier,$aRawEntity['score_modifier']);
        $this->assertEquals($oEntity->fScoreMultiplier,$aRawEntity['score_multiplier']);
        $this->assertEquals($oEntity->iOrderSeq,$aRawEntity['order_seq']);
        $this->assertEquals($oEntity->iAdjustmentGroupEP,$aRawEntity['rule_group_ep']);
        
        $this->assertEquals($oEntity->sScoreName,$aRawEntity['score_name']);
        $this->assertEquals($oEntity->sAdjustmentRuleName,$aRawEntity['rule_name']);
        $this->assertEquals($oEntity->sAdjustmentGroupName,$aRawEntity['rule_group_name']);
        
    }
    
    public function testCalculationAdjGroupBuilder()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_transaction_group')
                         ->getEntityBuilder();
      
        $sAlias   = $oBuilder->getTableQueryAlias().'_';
        
          $aRawEntity = array(
            $sAlias.'event_id'          => 9,
            $sAlias.'score_ep'          => 4,
            $sAlias.'rule_group_ep'     => 3,
            $sAlias.'score_modifier'    => 8,
            $sAlias.'score_multiplier'  => 1.5,
            $sAlias.'order_seq'         => 1,
            'score_name'                => 'score1',
            'rule_group_name'           => 'group1',
           
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
         
           
        $this->assertEquals($aRawEntity[$sAlias.'event_id'],$oEntity->iScoringEventID);
        $this->assertEquals($aRawEntity[$sAlias.'score_ep'],$oEntity->iScoreEP);
        $this->assertEquals($aRawEntity[$sAlias.'rule_group_ep'],$oEntity->iAdjustmentGroupEP);
        $this->assertEquals($aRawEntity[$sAlias.'score_modifier'],$oEntity->fScoreModifier);
        $this->assertEquals($aRawEntity[$sAlias.'score_multiplier'],$oEntity->fScoreMultiplier);
        $this->assertEquals($aRawEntity[$sAlias.'order_seq'],$oEntity->iOrderSeq);
        
        $this->assertEquals($aRawEntity['score_name'],$oEntity->sScoreName);
        $this->assertEquals($aRawEntity['rule_group_name'],$oEntity->sAdjustmentGroupName);
        
        
        
         $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
        $this->assertEquals($oEntity->iScoreEP,$aRawEntity['score_ep']);
        $this->assertEquals($oEntity->iAdjustmentGroupEP,$aRawEntity['rule_group_ep']);
        $this->assertEquals($oEntity->fScoreModifier,$aRawEntity['score_modifier']);
        $this->assertEquals($oEntity->fScoreMultiplier,$aRawEntity['score_multiplier']);
        $this->assertEquals($oEntity->iOrderSeq,$aRawEntity['order_seq']);
        $this->assertEquals($oEntity->sAdjustmentGroupName,$aRawEntity['rule_group_name']);
        $this->assertEquals($oEntity->sScoreName,$aRawEntity['score_name']);
         
         
    }
    
  
    
   
    
  
    
}
/* End of Class */

