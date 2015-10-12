<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystem;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;



class SystemEntityTest extends TestWithContainer
{
    
    public function getDataSet()
    {
      return new ArrayDataSet(__DIR__.'/'.'ExampleSystemFixture.php');
    }
    
    
    public function testEntityDelete()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        
        $oEntity = new PointSystem($oGateway,$oLogger);
        
        
        
        
        
    }
    
    
    
}
/* End of File */