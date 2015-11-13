<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\CalculationAdjRule;

/**
  *  Builder for Calculation Adjustment Rule Transactions
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class CalculationAdjRuleBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\CalculationAdjRule
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oRule = new CalculationAdjRule($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oRule->iScoringEventID     = $this->getField($data,'event_id',$sAlias); 
        $oRule->iAdjustmentRuleEP   = $this->getField($data,'rule_ep',$sAlias); 
        $oRule->iScoreEP            = $this->getField($data,'score_ep',$sAlias); 
        $oRule->fScoreModifier      = $this->getField($data,'score_modifier',$sAlias); 
        $oRule->fScoreMultiplier    = $this->getField($data,'score_multiplier',$sAlias); 
        $oRule->iOrderSeq           = $this->getField($data,'order_seq',$sAlias); 
         
        return $oRule;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\CalculationAdjRule    $oCalculation   the entity to convert
      */
    public function demolish($oCalculation)
    {
        return array(
             'event_id'      => $oCalculation->iScoringEventID
            ,'rule_ep'       => $oCalculation->iAdjustmentRuleEP 
            ,'score_ep'      => $oCalculation->iScoreEP
            ,'score_modifier'=> $oCalculation->fScoreModifier
            ,'score_multiplier' => $oCalculation->fScoreMultiplier
           
        );
        
    }
    
    
}
/* End of File */