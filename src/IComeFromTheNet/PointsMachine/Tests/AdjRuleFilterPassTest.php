<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\CompilerTest;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\AdjRuleFilterPass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class AdjRuleFilterPassTest extends CompilerTest
{
   
    protected $aFixtures = ['example-system.php','pass-adjrule-before.php'];
     
     
     
     
    public function testPassSuccessful()
    {
        $oContainer = $this->getContainer();
        $oResult = new CompileResult();
        
        $oPass = new AdjRuleFilterPass($oContainer->getDatabaseAdaper(),$oContainer->getGatewayCollection());
        
        
        $oPass->execute(new DateTime('now'), $oResult);
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','pass-adjrule-after.php'])->getTable('pt_result_rule');
        $oActualDataset = $this->getConnection()->createDataSet(array('pt_result_rule'))->getTable('pt_result_rule');
        
        $this->assertTablesEqual($oExpectedDataset,$oActualDataset);
        
    }
    
}
/* End of class */