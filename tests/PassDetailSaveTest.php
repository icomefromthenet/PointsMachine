<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\CompilerTest;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\DetailSavePass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class PassDetailSaveTest extends CompilerTest
{
   
    protected $aFixtures = ['example-system.php','pass-detail-before.php'];
     
     
     
     
    public function testPassSuccessful()
    {
        $oContainer = $this->getContainer();
        $oResult = new CompileResult();
        
        $oPass = new DetailSavePass($oContainer->getDatabaseAdaper(),$oContainer->getGatewayCollection());
        
        
        $oPass->execute(new DateTime('now'), $oResult);
        
        //$oExpectedDataset = $this->getDataSet(['example-system.php','pass-detail-after.php'])->getTable('pt_result_detail');
        //$oActualDataset = $this->getConnection()->createDataSet(array('pt_result_detail'))->getTable('pt_result_detail');
        
        //$this->assertTablesEqual($oExpectedDataset,$oActualDataset);
        
    }
    
}
/* End of class */