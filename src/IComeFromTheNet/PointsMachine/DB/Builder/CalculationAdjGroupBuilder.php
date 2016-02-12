<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\CalculationAdjGroup;

/**
  *  Builder for Calculation Transactions
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class CalculationAdjGroupBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\CalculationAdjGroup
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oRule = new CalculationAdjGroup($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oRule->iScoringEventID     = $this->getField($data,'event_id',$sAlias); 
        $oRule->iScoreEP            = $this->getField($data,'score_ep',$sAlias); 
        $oRule->iAdjustmentGroupEP  = $this->getField($data,'rule_group_ep',$sAlias); 
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
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\CalculationAdjGroup    $oCalculation   the entity to convert
      */
    public function demolish($oCalculation)
    {
        return array(
            'event_id'          => $oCalculation->iScoringEventID,
            'score_ep'          => $oCalculation->iScoreEP, 
            'rule_group_ep'     => $oCalculation->iAdjustmentGroupEP,
            'score_modifier'    => $oCalculation->fScoreModifier,
            'score_multiplier'  => $oCalculation->fScoreMultiplier,
            'order_seq'         => $oCalculation->iOrderSeq
        );
        
    }
    
    
}
/* End of File */