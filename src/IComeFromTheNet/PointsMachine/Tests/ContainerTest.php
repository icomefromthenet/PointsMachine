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
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_rule');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentRuleGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_rule_sys_zone');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\AdjustmentZoneGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_transaction_header');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\CalculationEventGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_transaction_score');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\CalculationScoreGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_transaction_group');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\CalculationAdjGroupGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_transaction_rule');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\CalculationAdjRuleGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_rule_chain');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\RuleChainGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_chain_member');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\DB\Gateway\RuleChainMemberGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_score');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpScoresGateway',$oGateway);
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oGateway->getTableMaker());
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_rule');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpAdjRuleGateway',$oGateway);
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oGateway->getTableMaker());
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_cjoin');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpCrossJoinGateway',$oGateway);
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oGateway->getTableMaker());
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_common');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpCommonGateway',$oGateway);
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oGateway->getTableMaker());
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_agg');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpAggValueGateway',$oGateway);
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oGateway->getTableMaker());
        

        $oGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_rank');
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Gateway\TmpRankGateway',$oGateway);
        $this->assertInstanceOf('IComeFromTheNet\PointsMachine\Compiler\Driver\DriverInterface',$oGateway->getTableMaker());
        
        
        
    }
    
    
    
}
/* End of class */