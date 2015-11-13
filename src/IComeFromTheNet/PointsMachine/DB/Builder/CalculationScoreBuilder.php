<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\CalculationScore;

/**
  *  Builder for Calculation Score Transactions
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class CalculationScoreBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\CalculationScore
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oRule = new CalculationScore($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oRule->iScoringEventID     = $this->getField($data,'event_id',$sAlias); 
        $oRule->iScoreEP            = $this->getField($data,'score_ep',$sAlias); 
        $oRule->iScoreGroupEP       = $this->getField($data,'score_group_ep',$sAlias); 
        $oRule->fScoreBase          = $this->getField($data,'score_base',$sAlias); 
        $oRule->fScoreCalRaw        = $this->getField($data,'score_cal_raw',$sAlias); 
        $oRule->fScoreCalRounded    = $this->getField($data,'score_cal_rounded',$sAlias); 
        $oRule->fScoreCalCapped     = $this->getField($data,'score_cal_capped',$sAlias); 
         
        return $oRule;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\CalculationScore    $oCalculation   the entity to convert
      */
    public function demolish($oCalculation)
    {
        return array(
            'event_id'      => $oCalculation->iScoringEventID,
            'score_ep'      => $oCalculation->iScoreEP, 
            'score_group_ep'=> $oCalculation->iScoreGroupEP,
            'score_base'    => $oCalculation->fScoreBase,
            'score_cal_raw' => $oCalculation->fScoreCalRaw,
            'score_cal_rounded' => $oCalculation->fScoreCalRounded,
            'score_cal_capped' => $oCalculation->fScoreCalCapped,
            
        );
        
    }
    
    
}
/* End of File */