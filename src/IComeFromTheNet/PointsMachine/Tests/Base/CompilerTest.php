<?php
namespace IComeFromTheNet\PointsMachine\Tests\Base;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\ScoreFilterPass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class CompilerTest extends TestWithContainer
{
   
    protected $aFixtures = ['example-system.php'];
     
     
    public function setUp()
    {
        $oContainer        = $this->getContainer();
        $oTmpScoreGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_score');
        $oTmpRuleGateway   = $oContainer->getGatewayCollection()->getGateway('pt_result_rule');
        $oTmpCommonGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_common');
        $oTmpCJoinGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_cjoin');
        $oTmpResHeaderGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_header');
        $oTmpResDetailGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_detail');
    
        
        # Create the tmp tables
        $oTmpScoreGateway->getTableMaker()->createTable();
        $oTmpRuleGateway->getTableMaker()->createTable();
        $oTmpCommonGateway->getTableMaker()->createTable();
        $oTmpCJoinGateway->getTableMaker()->createTable();
        $oTmpResHeaderGateway->getTableMaker()->createTable();
        $oTmpResDetailGateway->getTableMaker()->createTable();
        
        parent::setUp();
    }
    
    public function  tearDown()
    {
        $oContainer        = $this->getContainer();
        $oTmpScoreGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_score');
        $oTmpRuleGateway   = $oContainer->getGatewayCollection()->getGateway('pt_result_rule');
        $oTmpCommonGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_common');
        $oTmpCJoinGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_cjoin');
        $oTmpResHeaderGateway = $oContainer->getGatewayCollection()->getGateway('pt_result_header');
        $oTmpResDetailGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_detail');
    
        
        # Create the tmp tables
        $oTmpScoreGateway->getTableMaker()->removeTable();
        $oTmpRuleGateway->getTableMaker()->removeTable();
        $oTmpCommonGateway->getTableMaker()->removeTable();
        $oTmpCJoinGateway->getTableMaker()->removeTable(); 
        $oTmpResHeaderGateway->getTableMaker()->removeTable();
        $oTmpResDetailGateway->getTableMaker()->removeTable();
    
         
        parent::tearDown();
    }
     
   
    
}
/* End of class */