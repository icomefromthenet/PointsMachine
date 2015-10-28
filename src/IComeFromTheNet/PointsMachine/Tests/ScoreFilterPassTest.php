<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\ScoreFilterPass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class ScoreFilterPassTest extends TestWithContainer
{
   
    protected $aFixtures = ['example-system.php','pass-score-before.php'];
     
     
    public function setUp()
    {
        $oContainer        = $this->getContainer();
        $oTmpScoreGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_score');
        $oTmpRuleGateway   = $oContainer->getGatewayCollection()->getGateway('pt_result_rule');
        
        # Create the tmp tables
        $oTmpScoreGateway->getTableMaker()->createTable();
        $oTmpRuleGateway->getTableMaker()->createTable();
     
        
        parent::setUp();
    }
    
    public function  tearDown()
    {
        $oContainer        = $this->getContainer();
        $oTmpScoreGateway  = $oContainer->getGatewayCollection()->getGateway('pt_result_score');
        $oTmpRuleGateway   = $oContainer->getGatewayCollection()->getGateway('pt_result_rule');
        
        # Create the tmp tables
        $oTmpScoreGateway->getTableMaker()->removeTable();
        $oTmpRuleGateway->getTableMaker()->removeTable();
        
         
        parent::tearDown();
    }
     
     
     
     
    public function testPassSuccessful()
    {
        $oContainer = $this->getContainer();
        $oResult = new CompileResult();
        
        $oPass = new ScoreFilterPass($oContainer->getDatabaseAdaper(),$oContainer->getGatewayCollection());
        
        
        $oPass->execute(new DateTime('now'), $oResult);
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','pass-score-after.php'])->getTable('pt_result_score');
        $oActualDataset = $this->getConnection()->createDataSet(array('pt_result_score'))->getTable('pt_result_score');
        
        $this->assertTablesEqual($oExpectedDataset,$oActualDataset);
        
    }
    
}
/* End of class */