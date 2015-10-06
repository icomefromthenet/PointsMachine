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
    
    public function testEventTypesBuilder()
    {
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_event_type')
                         ->getEntityBuilder();
      
        $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlais.'episode_id' => 1,
            $sAlais.'event_type_id' =>  '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlais.'event_name' => 'Demo Event A',
            $sAlais.'event_name_slug' => 'demo_event_a',
            $sAlais.'enabled_from' => new DateTime(),
            $sAlais.'enabled_to' => new DateTime('3000-01-01'),
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlais.'episode_id'],$oEntity->iEpisodeID);
        $this->assertEquals($aRawEntity[$sAlais.'event_type_id'],$oEntity->sEventTypeID);
        $this->assertEquals($aRawEntity[$sAlais.'event_name'],$oEntity->sEventName);
        $this->assertEquals($aRawEntity[$sAlais.'event_name_slug'],$oEntity->sEventNameSlug);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_from'],$oEntity->oEnabledFrom);
        $this->assertEquals($aRawEntity[$sAlais.'enabled_to'],$oEntity->oEnabledTo);
    
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
      
        $sAlais   = $oBuilder->getTableQueryAlias().'_';
        
        # test build
        
        $aRawEntity = array(
            $sAlais.'event_id'      => 1,
            $sAlais.'event_type_id' => '12FF4301-C20D-A9BB-6BFE-1FEFC41BEF41',
            $sAlais.'event_created' => new DateTime(),
            $sAlais.'process_date'  => new DateTime('now +5 day'),
            $sAlais.'occured_date'  => new DateTime('now -10 day'),
    
        );
        
        $oEntity = $oBuilder->build($aRawEntity);
        
        $this->assertEquals($aRawEntity[$sAlais.'event_id'],$oEntity->iScoringEventID);
        $this->assertEquals($aRawEntity[$sAlais.'event_type_id'],$oEntity->sEventTypeID);
        $this->assertEquals($aRawEntity[$sAlais.'event_created'],$oEntity->oCreatedDate);
        $this->assertEquals($aRawEntity[$sAlais.'process_date'],$oEntity->oProcessDate);
        $this->assertEquals($aRawEntity[$sAlais.'occured_date'],$oEntity->oOccuredDate);
    
        $aRawEntity = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($oEntity->iScoringEventID,$aRawEntity['event_id']);
        $this->assertEquals($oEntity->sEventTypeID,$aRawEntity['event_type_id']);
        $this->assertEquals($oEntity->oCreatedDate,$aRawEntity['event_created']);
        $this->assertEquals($oEntity->oProcessDate,$aRawEntity['process_date']);
        $this->assertEquals($oEntity->oOccuredDate,$aRawEntity['occured_date']);
    
        
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

    public function testScoringGroupBuilder()
    {
        
        $oBuilder = $this->getContainer()
                         ->getGatewayCollection()
                         ->getGateway('pt_rule_group')
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
    
}
/* End of Class */
