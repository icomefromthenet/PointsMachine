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
    
    public function testEventTypes()
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
    
}
/* End of Class */
