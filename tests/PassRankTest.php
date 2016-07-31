<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\CompilerTest;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;
use IComeFromTheNet\PointsMachine\Compiler\Pass\RankPass;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;


class PassRankTest extends CompilerTest
{
   
    protected $aFixtures = ['example-system.php','pass-rank-before.php'];
     
     
     
     
    public function testPassSuccessful()
    {
        $oContainer = $this->getContainer();
        $oResult = new CompileResult();
        
        $oPass = new RankPass($oContainer->getDatabaseAdaper(),$oContainer->getGatewayCollection());
        
        
        $oPass->execute(new DateTime('now'), $oResult);
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','pass-rank-after.php'])->getTable('pt_result_rank');
        $oActualDataset = $this->getConnection()->createDataSet(array('pt_result_rank'))->getTable('pt_result_rank');
        
        $this->assertTablesEqual($oExpectedDataset,$oActualDataset);
        
    }
    
}
/* End of class */