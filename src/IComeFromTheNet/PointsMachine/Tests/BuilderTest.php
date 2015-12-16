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
        
        $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlais.'episode_id' => 1,
            $sAlais.'system_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlais.'system_name' => 'Demo A',
            $sAlais.'system_name_slug' => 'demo_a',
            $sAlais.'enabled_from' => new DateTime(),
            $sAlais.'enabled_to' => new DateTime('3000-01-01'),
        );
        
        $oPointsSystem = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oPointsSystem->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlais.'system_id'],$oPointsSystem->sSystemID);
        $this->assertEquals($aRawEntity[$sAlais.'system_name'],$oPointsSystem->sSystemName);
        $this->assertEquals($aRawEntity[$sAlais.'system_name_slug'],$oPointsSystem->sSystemNameSlug);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oPointsSystem->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oPointsSystem->oEnabledTo);
        
        
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
        
        $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlais.'episode_id' => 1,
            $sAlais.'system_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlais.'zone_id' =>  'ACAAF45C-FE62-909B-5CCD-3D967F3F8531',
            $sAlais.'zone_name' => 'Demo Zone A',
            $sAlais.'zone_name_slug' => 'demo_zone_a',
            $sAlais.'enabled_from' => new DateTime(),
            $sAlais.'enabled_to' => new DateTime('3000-01-01'),
        );
        
        $oPointsSystemZone = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oPointsSystemZone->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlais.'system_id'],$oPointsSystemZone->sSystemID);
        $this->assertEquals($aRawEntity[$sAlais.'zone_id'],$oPointsSystemZone->sZoneID);
        $this->assertEquals($aRawEntity[$sAlais.'zone_name'],$oPointsSystemZone->sZoneName);
        $this->assertEquals($aRawEntity[$sAlais.'zone_name_slug'],$oPointsSystemZone->sZoneNameSlug);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oPointsSystemZone->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oPointsSystemZone->oEnabledTo);
        
        
        # test demolish
        
        $aRawEntity = $oBuilder->demolish($oPointsSystemZone);
        
        $this->assertEquals($oPointsSystemZone->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oPointsSystemZone->sSystemID,$aRawEntity['system_id']);
        $this->assertEquals($oPointsSystemZone->sZoneID,$aRawEntity['zone_id']);
        $this->assertEquals($oPointsSystemZone->sZoneName,$aRawEntity['zone_name']);
        $this->assertEquals($oPointsSystemZone->sZoneNameSlug,$aRawEntity['zone_name_slug']);
        $this->assertEquals($oPointsSystemZone->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oPointsSystemZone->oEnabledTo,$aRawEntity['enabled_to']);
        
       
    }
    
    
    public function testScoreGroupBuilder()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_score_group')
                         ->getEntityBuilder();
      
        $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlais.'episode_id'    => 1,
            $sAlais.'score_group_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlais.'group_name' => 'Demo Event A',
            $sAlais.'group_name_slug' => 'demo_event_a',
            $sAlais.'enabled_from' => new DateTime(),
            $sAlais.'enabled_to' => new DateTime('3000-01-01'),
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlais.'score_group_id'],$oEntity->sScoreGroupID);
        $this->assertEquals($aRawEntity[$sAlais.'group_name'],$oEntity->sGroupName);
        $this->assertEquals($aRawEntity[$sAlais.'group_name_slug'],$oEntity->sGroupNameSlug);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
    
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
      
        $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlais.'episode_id'      => 1,
            $sAlais.'score_id'        => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
            $sAlais.'score_group_id'  => '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlais.'score_name'      => 'Demo Score A',
            $sAlais.'score_name_slug' => 'demo_score_a',
            $sAlais.'score_value'     => 100,
            $sAlais.'enabled_from'    => new DateTime(),
            $sAlais.'enabled_to'      => new DateTime('3000-01-01'),
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlais.'score_id'],$oEntity->sScoreID);
        $this->assertEquals($aRawEntity[$sAlais.'score_group_id'],$oEntity->sScoreGroupID);
        $this->assertEquals($aRawEntity[$sAlais.'score_name'],$oEntity->sScoreName);
        $this->assertEquals($aRawEntity[$sAlais.'score_name_slug'],$oEntity->sScoreNameSlug);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
        $this->assertEquals($aRawEntity[$sAlais.'score_value'],$oEntity->fScoreValue);
    
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
        $this->assertEquals($oEntity->sScoreID,$aRawEntity['score_id']);
        $this->assertEquals($oEntity->sScoreGroupID,$aRawEntity['score_group_id']);
        $this->assertEquals($oEntity->sScoreName,$aRawEntity['score_name']);
        $this->assertEquals($oEntity->sScoreNameSlug,$aRawEntity['score_name_slug']);
        $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
        $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
        
        
        
    }
    
    public function testRuleChainBuilder()
    {
          $oBuilder = $this->getContainer()
                          ->getGatewayCollection()
                          ->getGateway('pt_rule_chain')
                          ->getEntityBuilder();
      
         $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
         # test build
        
         $aRawEntity = array(
             $sAlais.'episode_id'      => 1,
             $sAlais.'rule_chain_id'   =>  'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlais.'event_type_id'   =>  'H5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlais.'system_id'       =>  'I5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlais.'chain_name'      => 'Chain A',
             $sAlais.'chain_name_slug' => 'chain_a',
             $sAlais.'rounding_option' => 2,
             $sAlais.'cap_value'       => 100,
             $sAlais.'enabled_from'    => new DateTime(),
             $sAlais.'enabled_to'      => new DateTime('3000-01-01'),
         );
        
         $oEntity = $oBuilder->build($aRawEntity);
        
         $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
         $this->assertEquals($aRawEntity[$sAlais.'rule_chain_id'],$oEntity->sRuleChainID);
         $this->assertEquals($aRawEntity[$sAlais.'event_type_id'],$oEntity->sEventTypeID);
         $this->assertEquals($aRawEntity[$sAlais.'system_id'],$oEntity->sSystemID);
         $this->assertEquals($aRawEntity[$sAlais.'chain_name'],$oEntity->sChainName);
         $this->assertEquals($aRawEntity[$sAlais.'chain_name_slug'],$oEntity->sChainNameSlug);
         $this->assertEquals($aRawEntity[$sAlais.'rounding_option'],$oEntity->iRoundingOption);
         $this->assertEquals($aRawEntity[$sAlais.'cap_value'],$oEntity->fCapValue);
         $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
         $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
        
        
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
       
        
     }
     
    public function testRuleChainMemberBuilder()
    {
          $oBuilder = $this->getContainer()
                          ->getGatewayCollection()
                          ->getGateway('pt_chain_member')
                          ->getEntityBuilder();
      
         $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
         # test build
        
         $aRawEntity = array(
             $sAlais.'episode_id'      => 1,
             $sAlais.'chain_member_id' =>  'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlais.'rule_chain_id'   =>  'H5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlais.'rule_group_id'   =>  'I5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
             $sAlais.'order_seq'       => 2,
             $sAlais.'enabled_from'    => new DateTime(),
             $sAlais.'enabled_to'      => new DateTime('3000-01-01'),
         );
        
         $oEntity = $oBuilder->build($aRawEntity);
        
         $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
         $this->assertEquals($aRawEntity[$sAlais.'rule_chain_id'],$oEntity->sRuleChainID);
         $this->assertEquals($aRawEntity[$sAlais.'chain_member_id'],$oEntity->sRuleChainMemberID);
         $this->assertEquals($aRawEntity[$sAlais.'rule_group_id'],$oEntity->sAdjustmentGroupID);
         $this->assertEquals($aRawEntity[$sAlais.'order_seq'],$oEntity->iOrderSeq);
         $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
         $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
        
        
         $aRawEntity = $oBuilder->demolish($oEntity);
        
         $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
         $this->assertEquals($oEntity->sRuleChainID,$aRawEntity['rule_chain_id']);
         $this->assertEquals($oEntity->sRuleChainMemberID,$aRawEntity['chain_member_id']);
         $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
         $this->assertEquals($oEntity->iOrderSeq,$aRawEntity['order_seq']);
         $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
         $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
       
        
     }
    
    
    // public function testEventTypesBuilder()
    // {
    //     $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_event_type')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //     # test build
        
    //     $aRawEntity = array(
    //         $sAlais.'episode_id' => 1,
    //         $sAlais.'event_type_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
    //         $sAlais.'event_name' => 'Demo Event A',
    //         $sAlais.'event_name_slug' => 'demo_event_a',
    //         $sAlais.'enabled_from' => new DateTime(),
    //         $sAlais.'enabled_to' => new DateTime('3000-01-01'),
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
        
    //     $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
    //     $this->assertEquals($aRawEntity[$sAlais.'event_type_id'],$oEntity->sEventTypeID);
    //     $this->assertEquals($aRawEntity[$sAlais.'event_name'],$oEntity->sEventName);
    //     $this->assertEquals($aRawEntity[$sAlais.'event_name_slug'],$oEntity->sEventNameSlug);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
    
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
    //     $this->assertEquals($oEntity->sEventTypeID,$aRawEntity['event_type_id']);
    //     $this->assertEquals($oEntity->sEventName,$aRawEntity['event_name']);
    //     $this->assertEquals($oEntity->sEventNameSlug,$aRawEntity['event_name_slug']);
    //     $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
    //     $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
        
    // }
    
    // public function testEventBuilder()    
    // {
    //     $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_event')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //     # test build
        
    //     $aRawEntity = array(
    //         $sAlais.'event_id'      => 1,
    //         $sAlais.'event_type_id' => '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
    //         $sAlais.'event_created' => new DateTime(),
    //         $sAlais.'process_date'  => new DateTime('now +5 day'),
    //         $sAlais.'occured_date'  => new DateTime('now -10 day'),
    
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
        
    //     $this->assertEquals($aRawEntity[$sAlais.'event_id'],$oEntity->iScoringEventID);
    //     $this->assertEquals($aRawEntity[$sAlais.'event_type_id'],$oEntity->sEventTypeID);
    //     $this->assertEquals($aRawEntity[$sAlais.'event_created'],$oEntity->oCreatedDate);
    //     $this->assertEquals($aRawEntity[$sAlais.'process_date'],$oEntity->oProcessDate);
    //     $this->assertEquals($aRawEntity[$sAlais.'occured_date'],$oEntity->oOccuredDate);
    
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
    //     $this->assertEquals($oEntity->sEventTypeID,$aRawEntity['event_type_id']);
    //     $this->assertEquals($oEntity->oCreatedDate,$aRawEntity['event_created']);
    //     $this->assertEquals($oEntity->oProcessDate,$aRawEntity['process_date']);
    //     $this->assertEquals($oEntity->oOccuredDate,$aRawEntity['occured_date']);
    
        
    // }
    
    
    

    // public function testAdjustmentGroupBuilder()
    // {
        
    //     $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_rule_group')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //     # test build
        
    //     $aRawEntity = array(
    //         $sAlais.'episode_id'           => 1,
    //         $sAlais.'rule_group_id'        => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'rule_group_name'      => 'Scoring Group A',
    //         $sAlais.'rule_group_name_slug' => 'scoring_group_a',
    //         $sAlais.'max_multiplier'       => 100,
    //         $sAlais.'min_multiplier'       => 1,
    //         $sAlais.'max_modifier'         => 200,
    //         $sAlais.'min_modifier'         => 2,
    //         $sAlais.'max_count'            => 5,
    //         $sAlais.'order_method'         => 1,
    //         $sAlais.'is_mandatory'         => 1,
    //         $sAlais.'enabled_from'         => new DateTime(),
    //         $sAlais.'enabled_to'           => new DateTime('3000-01-01'),
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
        
    //     $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_group_id'],$oEntity->sAdjustmentGroupID);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_group_name'],$oEntity->sGroupName);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_group_name_slug'],$oEntity->sGroupNameSlug);
    //     $this->assertEquals($aRawEntity[$sAlais.'max_multiplier'],$oEntity->fMaxMultiplier);
    //     $this->assertEquals($aRawEntity[$sAlais.'min_multiplier'],$oEntity->fMinMultiplier);
    //     $this->assertEquals($aRawEntity[$sAlais.'max_modifier'],$oEntity->fMaxModifier);
    //     $this->assertEquals($aRawEntity[$sAlais.'min_modifier'],$oEntity->fMinModifier);
    //     $this->assertEquals($aRawEntity[$sAlais.'max_count'],$oEntity->iMaxCount);
    //     $this->assertEquals($aRawEntity[$sAlais.'order_method'],$oEntity->iOrderMethod);
    //     $this->assertTrue($oEntity->bIsMandatory);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
        
        
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
    //     $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
    //     $this->assertEquals($oEntity->sGroupName,$aRawEntity['rule_group_name']);
    //     $this->assertEquals($oEntity->sGroupNameSlug,$aRawEntity['rule_group_name_slug']);
    //     $this->assertEquals($oEntity->fMaxMultiplier,$aRawEntity['max_multiplier']);
    //     $this->assertEquals($oEntity->fMinMultiplier,$aRawEntity['min_multiplier']);
    //     $this->assertEquals($oEntity->fMaxModifier,$aRawEntity['max_modifier']);
    //     $this->assertEquals($oEntity->fMinModifier,$aRawEntity['min_modifier']);
    //     $this->assertEquals($oEntity->iMaxCount,$aRawEntity['max_count']);
    //     $this->assertEquals($oEntity->iOrderMethod,$aRawEntity['order_method']);
    //     $this->assertEquals($oEntity->bIsMandatory,$aRawEntity['is_mandatory']);
    //     $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
    //     $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
        
        
    // }
    
    // public function testAdjustmentGroupLimitBuilder()
    // {
        
    //     $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_rule_group_limits')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //     # test build
        
    //     $aRawEntity = array(
    //         $sAlais.'rule_group_id'        => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'score_group_id'       => 'K5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'system_id'            => 'L5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'enabled_from'         => new DateTime(),
    //         $sAlais.'enabled_to'           => new DateTime('3000-01-01'),
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
        
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_group_id'],$oEntity->sAdjustmentGroupID);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_group_id'],$oEntity->sScoreGroupID);
    //     $this->assertEquals($aRawEntity[$sAlais.'system_id'],$oEntity->sSystemID);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
        
        
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
    //     $this->assertEquals($oEntity->sScoreGroupID,$aRawEntity['score_group_id']);
    //     $this->assertEquals($oEntity->sSystemID,$aRawEntity['system_id']);
    //     $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
    //     $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
        
    // }
    
    // public function testAdjustmentRuleBuilder()
    // {
    //     $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_rule')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //     # test build
        
    //     $aRawEntity = array(
    //         $sAlais.'episode_id'      => 1,
    //         $sAlais.'rule_id'         => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'rule_group_id'   => 'C5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'rule_name'       => 'Demo Adj Rule',
    //         $sAlais.'rule_name_slug'  => 'demo_adj_rule',
    //         $sAlais.'multiplier'      => 1.5,
    //         $sAlais.'modifier'        => 10.00,
    //         $sAlais.'invert_flag'     => 1,
    //         $sAlais.'enabled_from'    => new DateTime(),
    //         $sAlais.'enabled_to'      => new DateTime('3000-01-01'),
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
        
    //     $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_id'],$oEntity->sAdjustmentRuleID);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_group_id'],$oEntity->sAdjustmentGroupID);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_name'],$oEntity->sRuleName);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_name_slug'],$oEntity->sRuleNameSlug);
    //     $this->assertEquals($aRawEntity[$sAlais.'multiplier'],$oEntity->fMultiplier);
    //     $this->assertEquals($aRawEntity[$sAlais.'modifier'],$oEntity->fModifier);
    //     $this->assertEquals($aRawEntity[$sAlais.'invert_flag'],(int)$oEntity->bInvertFlag);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
        
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
    //     $this->assertEquals($oEntity->sAdjustmentRuleID,$aRawEntity['rule_id']);
    //     $this->assertEquals($oEntity->sAdjustmentGroupID,$aRawEntity['rule_group_id']);
    //     $this->assertEquals($oEntity->sRuleName,$aRawEntity['rule_name']);
    //     $this->assertEquals($oEntity->sRuleNameSlug,$aRawEntity['rule_name_slug']);
    //     $this->assertEquals($oEntity->fMultiplier,$aRawEntity['multiplier']);
    //     $this->assertEquals($oEntity->fModifier,$aRawEntity['modifier']);
    //     $this->assertEquals($oEntity->bInvertFlag,(bool)$aRawEntity['invert_flag']);
    //     $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
    //     $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
    // }
    
    // public function testAdjustmentZoneBuilder()
    // {
    //      $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_rule_sys_zone')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //     # test build
        
    //     $aRawEntity = array(
    //         $sAlais.'episode_id'      => 1,
    //         $sAlais.'rule_id'         => 'B5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'system_zone_id'   => 'C5D37F95-525F-9E4F-A5B7-F6EA3A269A34',
    //         $sAlais.'enabled_from'    => new DateTime(),
    //         $sAlais.'enabled_to'      => new DateTime('3000-01-01'),
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
        
    //     $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_id'],$oEntity->sAdjustmentRuleID);
    //     $this->assertEquals($aRawEntity[$sAlais.'system_zone_id'],$oEntity->sSystemZoneID);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
    //     $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
        
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iEpisodeID,$aRawEntity['episode_id']);
    //     $this->assertEquals($oEntity->sAdjustmentRuleID,$aRawEntity['rule_id']);
    //     $this->assertEquals($oEntity->sSystemZoneID,$aRawEntity['system_zone_id']);
    //     $this->assertEquals($oEntity->oEnabledFrom,$aRawEntity['enabled_from']);
    //     $this->assertEquals($oEntity->oEnabledTo,$aRawEntity['enabled_to']);
        
    // }
    
    // public function testCalculationEventBuilder()
    // {
    //       $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_transaction_header')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //       $aRawEntity = array(
    //         $sAlais.'event_id'          => 9,
    //         $sAlais.'system_ep'         => 6,
    //         $sAlais.'zone_ep'           => 7,
    //         $sAlais.'event_type_ep'     => 8,
    //         $sAlais.'created_date'      => new DateTime(),
    //         $sAlais.'processing_date'   => new DateTime('now + 1 day'),
    //         $sAlais.'occured_date'      => new DateTime('now - 5 day'),
           
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
         
    //     $this->assertEquals($aRawEntity[$sAlais.'event_id'],$oEntity->iScoringEventID);       
    //     $this->assertEquals($aRawEntity[$sAlais.'system_ep'],$oEntity->iSystemEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'zone_ep'],$oEntity->iSystemZoneEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'event_type_ep'],$oEntity->iEventTypeEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'created_date'],$oEntity->oCreatedDate);
    //     $this->assertEquals($aRawEntity[$sAlais.'processing_date'],$oEntity->oProcessingDate);
    //     $this->assertEquals($aRawEntity[$sAlais.'occured_date'],$oEntity->oOccuredDate);
         
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
    //     $this->assertEquals($oEntity->iSystemEP,$aRawEntity['system_ep']);
    //     $this->assertEquals($oEntity->iSystemZoneEP,$aRawEntity['zone_ep']);
    //     $this->assertEquals($oEntity->iEventTypeEP,$aRawEntity['event_type_ep']);
    //     $this->assertEquals($oEntity->oCreatedDate,$aRawEntity['created_date']);
    //     $this->assertEquals($oEntity->oProcessingDate,$aRawEntity['processing_date']);
    //     $this->assertEquals($oEntity->oOccuredDate,$aRawEntity['occured_date']);
         
    // }
    
    // public function testCalculationScoreBuilder()
    // {
    //       $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_transaction_score')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //       $aRawEntity = array(
    //         $sAlais.'event_id'          => 9,
    //         $sAlais.'score_ep'          => 4,
    //         $sAlais.'score_group_ep'    => 5,
    //         $sAlais.'score_base'        => 10,
    //         $sAlais.'score_raw'         => 11,
    //         $sAlais.'score_rounded'     => 12,
    //         $sAlais.'score_capped'      => 13,
            
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
         
    //     $this->assertEquals($aRawEntity[$sAlais.'event_id'],$oEntity->iScoringEventID);   
    //     $this->assertEquals($aRawEntity[$sAlais.'score_ep'],$oEntity->iScoreEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_group_ep'],$oEntity->iScoreGroupEP);
        
    //     $this->assertEquals($aRawEntity[$sAlais.'score_base'],$oEntity->fScoreBase);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_raw'],$oEntity->fScoreRaw);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_rounded'],$oEntity->fScoreRounded);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_capped'],$oEntity->fScoreCapped);
        
    //     $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
    //     $this->assertEquals($oEntity->iScoreEP,$aRawEntity['score_ep']);
    //     $this->assertEquals($oEntity->iScoreGroupEP,$aRawEntity['score_group_ep']);
    //     $this->assertEquals($oEntity->fScoreBase,$aRawEntity['score_base']);
    //     $this->assertEquals($oEntity->fScoreRaw,$aRawEntity['score_raw']);
    //     $this->assertEquals($oEntity->fScoreRounded,$aRawEntity['score_rounded']);
    //     $this->assertEquals($oEntity->fScoreCapped,$aRawEntity['score_capped']);
         
         
    // }
    
    // public function testCalculationAdjRuleBuilder()
    // {
    //   $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_transaction_rule')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //      $aRawEntity = array(
    //         $sAlais.'event_id'          => 9,
    //         $sAlais.'score_ep'          => 4,
    //         $sAlais.'rule_ep'           => 2,
    //         $sAlais.'score_modifier'    => 8,
    //         $sAlais.'score_multiplier'  => 1.5,
    //         $sAlais.'order_seq'         => 1,
           
    //     );
        
    //      $oEntity = $oBuilder->build($aRawEntity);
         
           
    //     $this->assertEquals($aRawEntity[$sAlais.'event_id'],$oEntity->iScoringEventID);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_ep'],$oEntity->iScoreEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_ep'],$oEntity->iAdjustmentRuleEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_modifier'],$oEntity->fScoreModifier);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_multiplier'],$oEntity->fScoreMultiplier);
    //     $this->assertEquals($aRawEntity[$sAlais.'order_seq'],$oEntity->iOrderSeq);
        
    //      $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
    //     $this->assertEquals($oEntity->iAdjustmentRuleID,$aRawEntity['rule_ep']);
    //     $this->assertEquals($oEntity->iScoreID,$aRawEntity['score_ep']);
    //     $this->assertEquals($oEntity->fScoreModifier,$aRawEntity['score_modifier']);
    //     $this->assertEquals($oEntity->fScoreMultiplier,$aRawEntity['score_multiplier']);
    //     $this->assertEquals($oEntity->iOrderSeq,$aRawEntity['order_seq']);
        
    // }
    
    // public function testCalculationAdjGroupBuilder()
    // {
    //     $oBuilder = $this->getContainer()
    //                      ->getGatewayCollection()
    //                      ->getGateway('pt_transaction_group')
    //                      ->getEntityBuilder();
      
    //     $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
    //       $aRawEntity = array(
    //         $sAlais.'event_id'          => 9,
    //         $sAlais.'score_ep'          => 4,
    //         $sAlais.'rule_group_ep'     => 3,
    //         $sAlais.'score_modifier'    => 8,
    //         $sAlais.'score_multiplier'  => 1.5,
    //         $sAlais.'order_seq'         => 1
            
           
    //     );
        
    //     $oEntity = $oBuilder->build($aRawEntity);
         
           
    //     $this->assertEquals($aRawEntity[$sAlais.'event_id'],$oEntity->iScoringEventID);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_ep'],$oEntity->iScoreEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'rule_group_ep'],$oEntity->iAdjustmentGroupEP);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_modifier'],$oEntity->fScoreModifier);
    //     $this->assertEquals($aRawEntity[$sAlais.'score_multiplier'],$oEntity->fScoreMultiplier);
    //     $this->assertEquals($oEntity->iOrderSeq,$aRawEntity['order_seq']);
        
    //      $aRawEntity = $oBuilder->demolish($oEntity);
        
    //     $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
    //     $this->assertEquals($oEntity->iScoreEP,$aRawEntity['score_ep']);
    //     $this->assertEquals($oEntity->iAdjustmentGroupEP,$aRawEntity['rule_group_ep']);
    //     $this->assertEquals($oEntity->fScoreModifier,$aRawEntity['score_modifier']);
    //     $this->assertEquals($oEntity->fScoreMultiplier,$aRawEntity['score_multiplier']);
    //     $this->assertEquals($oEntity->iOrderSeq,$aRawEntity['order_seq']);
         
    // }
    
  
    
   
    
  
    
}
/* End of Class */
