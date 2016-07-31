<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\CompilerTest;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\CommonFilterPass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class PassCommonFilterTest extends CompilerTest
{
   
    protected $aFixtures = ['example-system.php','pass-common-before.php'];
     
     
     
     
    public function testPassSuccessful()
    {
        $oContainer = $this->getContainer();
        $oResult = new CompileResult();
        
        $oPass = new CommonFilterPass($oContainer->getDatabaseAdaper(),$oContainer->getGatewayCollection());
        
        
        $oPass->execute(new DateTime('now'), $oResult);
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','pass-common-after.php'])->getTable('pt_result_common');
        $oActualDataset = $this->getConnection()->createDataSet(array('pt_result_common'))->getTable('pt_result_common');
        
        $this->assertTablesEqual($oExpectedDataset,$oActualDataset);
        
    }
    
}
/* End of class */