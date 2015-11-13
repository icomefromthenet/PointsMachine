<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\CalculationEvent;

/**
  *  Builder for Calculation Transactions
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class CalculationEventBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\CalculationEvent
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oRule = new CalculationEvent($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oRule->iScoringEventID     = $this->getField($data,'event_id',$sAlias); 
        $oRule->iSystemEP           = $this->getField($data,'system_ep',$sAlias); 
        $oRule->iSystemZoneEP       = $this->getField($data,'zone_ep',$sAlias); 
        $oRule->iEventTypeEP        = $this->getField($data,'event_type_ep',$sAlias); 
        $oRule->oCreatedDate        = $this->getField($data,'created_date',$sAlias); 
        $oRule->oProcessingDate     = $this->getField($data,'processing_date',$sAlias); 
        $oRule->oOccuredDate        = $this->getField($data,'occured_date',$sAlias); 
         
        return $oRule;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\CalculationEvent    $oCalculation   the entity to convert
      */
    public function demolish($oCalculation)
    {
        return array(
            'event_id'      => $oRule->iScoringEventID
            ,'system_ep'    => $oRule->iSystemEP
            ,'zone_ep'      => $oRule->iSystemZoneEP
            ,'event_type_ep' => $oRule->iEventTypeEP
            ,'created_date' => $oRule->oCreatedDate
            ,'processing_date' => $oRule->oProcessingDate
            ,'occured_date' => $oRule->oCreatedDate
            
        );
        
    }
    
    
}
/* End of File */