<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\CompilerTest;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\CrossJoinPass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class PassCrossJoinTest extends CompilerTest
{
   
    protected $aFixtures = ['example-system.php','pass-cjoin-before.php'];
     
     
     
     
    public function testPassSuccessful()
    {
        $oContainer = $this->getContainer();
        $oResult = new CompileResult();
        
        $oPass = new CrossJoinPass($oContainer->getDatabaseAdaper(),$oContainer->getGatewayCollection());
        
        
        $oPass->execute(new DateTime('now'), $oResult);
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','pass-cjoin-after.php'])->getTable('pt_result_cjoin');
        $oActualDataset = $this->getConnection()->createDataSet(array('pt_result_cjoin'))->getTable('pt_result_cjoin');
        
        $this->assertTablesEqual($oExpectedDataset,$oActualDataset);
        
    }
    
}
/* End of class */