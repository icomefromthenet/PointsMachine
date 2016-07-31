<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\CompilerTest;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\CapPass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class PassCapTest extends CompilerTest
{
   
    protected $aFixtures = ['example-system.php','pass-cap-before.php'];
     
     
     
     
    public function testPassSuccessful()
    {
        $oContainer = $this->getContainer();
        $oResult = new CompileResult();
        
        $oPass = new CapPass($oContainer->getDatabaseAdaper(),$oContainer->getGatewayCollection());
        
        
        $oPass->execute(new DateTime('now'), $oResult);
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','pass-cap-after.php'])->getTable('pt_result_score');
        $oActualDataset = $this->getConnection()->createDataSet(array('pt_result_score'))->getTable('pt_result_score');
        
        $this->assertTablesEqual($oExpectedDataset,$oActualDataset);
        
    }
    
}
/* End of class */