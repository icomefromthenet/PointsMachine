<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use IComeFromTheNet\PointsMachine\Tests\Base\SimpleArrayDataSet;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystem;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use PHPUnit_Extensions_Database_DataSet_CompositeDataSet;
use PHPUnit_Extensions_Database_DataSet_DataSetFilter;
use PHPUnit_Extensions_Database_DataSet_QueryDataSet;


class SystemEntityTest extends TestWithContainer
{
    
    public function getDataSet()
    {
      return new ArrayDataSet(__DIR__.'/'.'ExampleSystemFixture.php');
    }
    
    
    public function testEntitySave()
    {
        $oContainer = $this->getContainer();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('pt_system');
        $oLogger    = $oContainer->getAppLogger();
        $oProcessingDate = new DateTime();
       
        // Build the entity to save
        
        $sSystemId = '1E8659DA-127C-BE67-6DF5-EB6554AD4B0';
        $sSystemName = 'Mock System';
        $sSystemSlug = 'mock_system';
        $sEnabledFrom = $oGateway->getNow()->format('Y-m-d');
        $sEnabledTo   = (new DateTime('3000-01-01'))->format('Y-m-d');
        
        $oEntity = new PointSystem($oGateway,$oLogger);
        
        $oEntity->sSystemID = $sSystemId;
        $oEntity->sSystemName = $sSystemName;
        $oEntity->sSystemNameSlug = $sSystemSlug;
        
        // save the entity
        $bResult = $oEntity->save($oProcessingDate);
        $aResult = $oEntity->getLastQueryResult();
        
        $this->assertTrue($aResult['result']);
        $this->assertEquals('Inserted new Points System Episode',$aResult['msg']);
        $this->assertTrue($bResult);
        
        //Build the result set that we expect
        //where merging the default example set with new entity and removing tables we dont want checked
        
        $aResultData = new SimpleArrayDataSet([
            'pt_system' => 
                [
                    [
                        'episode_id' => null
                        ,'system_id'  => $sSystemId
                        ,'system_name' => $sSystemName
                        ,'system_name_slug' => $sSystemSlug
                        ,'enabled_from' => $sEnabledFrom
                        ,'enabled_to'   => $sEnabledTo
                    ]
                ]
            
        ]);
        
        
        $oCompositeDs = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet();
        $oCompositeDs->addDataSet($this->getDataSet());
        $oCompositeDs->addDataSet($aResultData);
        
        $oExpectedDataSet = new PHPUnit_Extensions_Database_DataSet_DataSetFilter($oCompositeDs);
        $oExpectedDataSet->addExcludeTables([
               'pt_system_zone'         => 'pt_system_zone' 
              ,'pt_event_type'          => 'pt_event_type'
              ,'pt_event'               => 'pt_event'
              ,'pt_score_group'         => 'pt_score_group'
              ,'pt_score'               => 'pt_score'
              ,'pt_rule_group'          => 'pt_rule_group'
              ,'pt_rule_group_limits'   => 'pt_rule_group_limits'
              ,'pt_rule'                => 'pt_rule'
              ,'pt_rule_sys_zone'       => 'pt_rule_sys_zone'
              ,'pt_scoring_transaction' => 'pt_scoring_transaction'
              ,'pt_rule_chain'          => 'pt_rule_chain'
              ,'pt_chain_member'        => 'pt_chain_member'
              
        ]);
        
        $oExpectedDataSet->setExcludeColumnsForTable('pt_system', array('episode_id'));
        
        // Build Dataset that compare against in the database
        
        $oQuerydataSet = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $oQuerydataSet->addTable('pt_system', 'SELECT system_id, system_id, system_name, system_name_slug, enabled_from, enabled_to FROM pt_system');
        
        
        $this->assertDataSetsEqual($oExpectedDataSet, $oQuerydataSet);
        
    }
    
    
    
}
/* End of File */