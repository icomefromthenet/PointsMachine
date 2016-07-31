<?php
namespace IComeFromTheNet\PointsMachine\Tests;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\PointsMachine\Tests\Base\TestWithContainer;
use IComeFromTheNet\PointsMachine\PointsMachine;
use IComeFromTheNet\PointsMachine\PointsMachineException;


class CalculatorTest extends TestWithContainer
{
   
    protected $aFixtures = ['example-system.php'];
     
     
    public function testFailsValidationBadGUID()
    {
        $oContainer = $this->getContainer();
    
        $oCal = $this->getMockBuilder('IComeFromTheNet\PointsMachine\PointsMachine')
                     ->setMethods(array('generateEventInstance','executeCompiler','seedTmpTables'))    
                     ->setConstructorArgs(array($oContainer))
                     ->getMock();
        
        
        try {
            $oCal->newRound();             
                $oCal->setEventType('s');
                //$oCal->setProcessingDate();
                $oCal->setPointSystem('d');
                $oCal->setPointSystemZone('a');
                //$oCal->setOccuredDate();
            $oCal->executeRound();
        } catch (PointsMachineException $e) {
            $this->assertEquals('Validation Error unable to continue',$e->getMessage());
        }
        
        $aError = $oCal->getLastValidationError();
        
        $this->assertEquals($aError['EventType'][0],'EventType contains invalid characters');
        $this->assertEquals($aError['PointSystem'][0],'PointSystem contains invalid characters');
        $this->assertEquals($aError['PointSystemZone'][0],'PointSystemZone contains invalid characters');
        //var_dump($aError);
        
    }
    
    public function testFailsValidationRequired()
    {
        $oContainer = $this->getContainer();
    
        $oCal = $this->getMockBuilder('IComeFromTheNet\PointsMachine\PointsMachine')
                     ->setMethods(array('generateEventInstance','executeCompiler','seedTmpTables'))    
                     ->setConstructorArgs(array($oContainer))
                     ->getMock();
        
        
        try {
            $oCal->newRound();             
               
            $oCal->executeRound();
        } catch (PointsMachineException $e) {
            $this->assertEquals('Validation Error unable to continue',$e->getMessage());
        }
        
        $aError = $oCal->getLastValidationError();
        
        $this->assertEquals($aError['EventType'][0],'EventType is required');
        $this->assertEquals($aError['PointSystem'][0],'PointSystem is required');
        $this->assertEquals($aError['ProcessingDate'][0],'ProcessingDate is required');
        
        
    }
    
    
    public function testGenerateEvent()
    {
        $oContainer = $this->getContainer();
    
        $oCal = $this->getMockBuilder('IComeFromTheNet\PointsMachine\PointsMachine')
                     ->setMethods(array('executeCompiler','seedTmpTables'))    
                     ->setConstructorArgs(array($oContainer))
                     ->getMock();
        
        
        // this will validate and generate a seed value
        $oCal->newRound();             
            $oCal->setEventType('AE825846-3F9B-5FF7-D414-F46890E5C733');
            $oCal->setPointSystem('9B753E70-881B-F53E-2D46-8151BED1BBAF');
            $oCal->setPointSystemZone('03D119A2-1B66-423C-401F-7CE384450CE5');
            $oCal->setOccuredDate(new DateTime());
            $oCal->setProcessingDate(new DateTime());
        $oCal->executeRound();
        
        $oExpectedDataset = $this->getDataSet(array_merge($this->aFixtures,['calculator-event-add.php']))
                                 ->getTable('pt_event');
        
        
        $this->assertTablesEqual($oExpectedDataset, $this->getConnection()->createDataSet()->getTable('pt_event'));
        
        
    }
    
    
    
    public function testGenerateSeed()
    {
        $oContainer = $this->getContainer();
    
        $oCal = $this->getMockBuilder('IComeFromTheNet\PointsMachine\PointsMachine')
                     ->setMethods(array('executeCompiler'))    
                     ->setConstructorArgs(array($oContainer))
                     ->getMock();
        
        
        // this will validate and generate a seed value
        $oCal->newRound();             
            $oCal->setEventType('AE825846-3F9B-5FF7-D414-F46890E5C733');
            $oCal->setPointSystem('9B753E70-881B-F53E-2D46-8151BED1BBAF');
            $oCal->setPointSystemZone('03D119A2-1B66-423C-401F-7CE384450CE5');
            $oCal->setOccuredDate(new DateTime());
            $oCal->setProcessingDate(new DateTime());
            
            $oCal->addScore('755D1FFF-A190-9F70-21A1-3BCFAB7A60AA');
            $oCal->addScore('66C19B18-0C52-29A2-09CE-0D9021EDB0CB');
            $oCal->addScore('EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0');
            
            $oCal->addAdjustmentRule('352F04DC-7338-A56F-75F8-29CC51B35EBE');
            $oCal->addAdjustmentRule('D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD');
            
            
        $oCal->executeRound();
        
        # match common table
        $oExpectedDataset = $this->getDataSet(array_merge($this->aFixtures,['calculator-seed-tmp.php']))
                                 ->getTable('pt_result_common');
        $this->assertTablesEqual($oExpectedDataset, $this->getConnection()->createDataSet(array('pt_result_common'))->getTable('pt_result_common'));
        
        
        
        # match score tmp table
        $oExpectedDataset = $this->getDataSet(array_merge($this->aFixtures,['calculator-seed-tmp.php']))
                                ->getTable('pt_result_score');
        $this->assertTablesEqual($oExpectedDataset, $this->getConnection()->createDataSet(array('pt_result_score'))->getTable('pt_result_score'));
        
        # match adj rule tmp table
        $oExpectedDataset = $this->getDataSet(array_merge($this->aFixtures,['calculator-seed-tmp.php']))
                                 ->getTable('pt_result_rule');
        $this->assertTablesEqual($oExpectedDataset, $this->getConnection()->createDataSet(array('pt_result_rule'))->getTable('pt_result_rule'));
        
        
        
    }
    
    
    
}
/* End of class */