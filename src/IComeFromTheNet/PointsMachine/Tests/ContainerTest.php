<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;


class ContainerTest extends TestWithContainer
{
   
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/ExampleFixture.php',
        ]);
    }
    
    
    public function testContainerDBGateways()
    {
        $oContainer = $this->getContainer();
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\PointSystemGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_system_zone');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\PointSystemZoneGateway',$oGateway);
         
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_event_type');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\EventTypeGateway',$oGateway);
    
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_score_group');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\ScoreGroupGateway',$oGateway);
    
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_score');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\ScoreGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_rule_group');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentGroupGateway',$oGateway);
        
         $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_rule_group_limits');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentGroupLimitGateway',$oGateway);
        
    }
    
    
    
}
/* End of class */