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
        $oCalculation = new CalculationEvent($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oCalculation->iScoringEventID     = $this->getField($data,'event_id',$sAlias); 
        $oCalculation->iSystemEP           = $this->getField($data,'system_ep',$sAlias); 
        $oCalculation->iSystemZoneEP       = $this->getField($data,'zone_ep',$sAlias); 
        $oCalculation->iEventTypeEP        = $this->getField($data,'event_type_ep',$sAlias); 
        $oCalculation->oCreatedDate        = $this->getField($data,'created_date',$sAlias); 
        $oCalculation->oProcessingDate     = $this->getField($data,'processing_date',$sAlias); 
        $oCalculation->oOccuredDate        = $this->getField($data,'occured_date',$sAlias); 
        $oCalculation->fCalRunValue        = $this->getField($data,'calrunvalue',$sAlias); 
        $oCalculation->fCalRunValueRound   = $this->getField($data,'calrunvalue_round',$sAlias); 
        
         
        // these come from join tables and will not be prefixes with alias 
        $oCalculation->sSystemName     = $data['system_name'];
        $oCalculation->sSystemZoneName = $data['zone_name'];
        $oCalculation->sEventName      = $data['event_name'];
             
         
        return $oCalculation;
    
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
            'event_id'      => $oCalculation->iScoringEventID
            ,'system_ep'    => $oCalculation->iSystemEP
            ,'zone_ep'      => $oCalculation->iSystemZoneEP
            ,'event_type_ep' => $oCalculation->iEventTypeEP
            ,'created_date' => $oCalculation->oCreatedDate
            ,'processing_date' => $oCalculation->oProcessingDate
            ,'occured_date' => $oCalculation->oOccuredDate
            ,'system_name'   => $oCalculation->sSystemName
            ,'zone_name'     => $oCalculation->sSystemZoneName
            ,'event_name'    => $oCalculation->sEventName
            ,'calrunvalue'   => $oCalculation->fCalRunValue
            ,'calrunvalue_round'  => $oCalculation->fCalRunValueRound
            
        );
        
    }
    
    
}
/* End of File */