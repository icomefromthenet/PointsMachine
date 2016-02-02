<?php 
namespace IComeFromTheNet\PointsMachine\DB\Entity;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonEntity;
use IComeFromTheNet\PointsMachine\DB\ActiveRecordInterface;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * Entity for the scoring events
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoringEvent extends CommonEntity implements ActiveRecordInterface
{
    
    protected $aValidation = [
         'required' => [
            ['event_type_id','processing_date','occured_date']
        ]
        ,'instanceOf' => [
            ['processing_date','DateTime'],['occured_date','DateTime']
        ]
        
    ];
    
    public $iScoringEventID;
    
    public $sEventTypeID;
    
    public $oProcessDate;
    
    public $oOccuredDate;
   
   
   protected function getDataForValidation()
   {
       return array(
           'scoring_event_id' => $this->iScoringEventID
           ,'event_type_id'   => $this->sEventTypeID
           ,'process_date'    => $this->oProcessDate
           ,'occured_date'    => $this->oOccuredDate
           
        );
       
   }
   
   protected function validateNew()
   {
       $aData = $this->getDataForValidation();
       $aRules = $this->aValidation;
        
       return $this->validate($aData,$aRules);
   }
    
   protected function validateUpdate()
   {
    
   }
          
   protected function validateRemove()
   {
    
    
   }
    
    
   public function save()
   {
      
       if(false === empty($this->iScoringEventID)) {
           throw new PointsMachineException('update operation not supported');
       }
       
        $bSuccess          = false;
        $this->aLastResult = array( 'result' => '','msg' =>'');
        $oGateway          = $this->getTableGateway();
        $oBuilder          = $oGateway->getEntityBuilder();
     
        $aDatabaseData = $oBuilder->demolish($this);
        
        try {
        
           if(true === $this->validateNew()) {
           
                $bSuccess = $oGateway->insertQuery()
                 ->start()
                    ->addColumn('event_type_id',        $aDatabaseData['event_type_id'])
                    ->addColumn('process_date',         $aDatabaseData['process_date'])
                    ->addColumn('occured_date',         $aDatabaseData['occured_date'])
                 ->end()
                ->insert(); 
        
                if($bSuccess) {
                        
                        $this->aLastResult['result'] = true;
                        $this->aLastResult['msg']    = 'Created new ScoringEvent';
                        $this->iScoringEventID       =  (int) $oGateway->lastInsertId();
                             
                } else {
                    
                    $this->aLastResult['result'] = false;
                    $this->aLastResult['msg']    = 'Unable to insert ScoringEvent.';
                    
                }
    
    
            } 
            
        
        } catch (Exception $e) {
           
            $this->getAppLogger()->error($e->getMessage());
        
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = $e->getMessage();
            throw $e; 
        }
      

       return $bSuccess;
       
       
       
   }
    
   public function remove()
   {
        throw new PointsMachineException('remove operation not supported');
   }
    
    
}
/* End of File */

