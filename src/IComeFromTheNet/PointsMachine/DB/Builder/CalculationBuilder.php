<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\Calculation;

/**
  *  Builder for Calculation Transactions
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class CalculationBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\Calculation
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oRule = new Calculation($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oRule->iProcessID          = $this->getField($data,'process_id',$sAlias);
        $oRule->iAdjustmentRuleID   = $this->getField($data,'rule_id',$sAlias); 
        $oRule->iAdjustmentGroupID  = $this->getField($data,'rule_group_id',$sAlias); 
        $oRule->iScoreID            = $this->getField($data,'score_id',$sAlias); 
        $oRule->iScoreGroupID       = $this->getField($data,'score_group_id',$sAlias); 
        $oRule->iSystemID           = $this->getField($data,'system_id',$sAlias); 
        $oRule->iSystemZoneID       = $this->getField($data,'zone_id',$sAlias); 
        $oRule->iEventTypeID        = $this->getField($data,'event_type_id',$sAlias); 
        $oRule->iScoringEventID     = $this->getField($data,'event_id',$sAlias); 
        $oRule->fScoreBase          = $this->getField($data,'score_base',$sAlias); 
        $oRule->fScoreBalance       = $this->getField($data,'score_balance',$sAlias);     
        $oRule->fScoreModifier      = $this->getField($data,'score_modifier',$sAlias); 
        $oRule->fScoreMultiplier    = $this->getField($data,'score_multiplier',$sAlias); 
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
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\Calculation    $oCalculation   the entity to convert
      */
    public function demolish($oCalculation)
    {
        return array(
            'process_id'    =>$oCalculation->iProcessID,
            'rule_id'       => $oCalculation->iAdjustmentRuleID, 
            'rule_group_id' => $oCalculation->iAdjustmentGroupID,
            'score_id'      => $oCalculation->iScoreID, 
            'score_group_id'=> $oCalculation->iScoreGroupID,
            'system_id'     => $oCalculation->iSystemID,
            'zone_id'       => $oCalculation->iSystemZoneID,
            'event_type_id' => $oCalculation->iEventTypeID,
            'event_id'      => $oCalculation->iScoringEventID,
            'score_base'    => $oCalculation->fScoreBase,
            'score_balance' => $oCalculation->fScoreBalance,
            'score_modifier'=> $oCalculation->fScoreModifier,
            'score_multiplier' => $oCalculation->fScoreMultiplier,
            'created_date'  => $oCalculation->oCreatedDate,
            'processing_date'=> $oCalculation->oProcessingDate,
            'occured_date'   => $oCalculation->oOccuredDate,
        );
        
    }
    
    
}
/* End of File */