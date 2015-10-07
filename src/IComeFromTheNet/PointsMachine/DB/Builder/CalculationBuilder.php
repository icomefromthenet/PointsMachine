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
        $oRule->iEventType          = $this->getField($data,'event_type_id',$sAlias); 
        $oRule->iScoringEvent       = $this->getField($data,'event_id',$sAlias); 
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
            'process_id'    =>$oRule->iProcessID,
            'rule_id'       => $oRule->iAdjustmentRuleID, 
            'rule_group_id' => $oRule->iAdjustmentGroupID
            'score_id'      => $oRule->iScoreID, 
            'score_group_id'=> $oRule->iScoreGroupID,
            'system_id'     => $oRule->iSystemID,
            'zone_id'       => $oRule->iSystemZoneID,
            'event_type_id' =>$oRule->iEventType,
            'event_id'      => $oRule->iScoringEvent,
            'score_base'    => $oRule->fScoreBase,
            'score_balance' => $oRule->fScoreBalance,
            'score_modifier'=> $oRule->fScoreModifier,
            'score_multiplier' => $oRule->fScoreMultiplier,
            'created_date'  => $oRule->oCreatedDate,
            'processing_date'=> $oRule->oProcessingDate,
            'occured_date'   => $oRule->oOccuredDate ,
        );
        
    }
    
    
}
/* End of File */