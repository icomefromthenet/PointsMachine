<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentRule;

/**
  *  Builder for Scoring Rules Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class AdjustmentRuleBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentRule
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oRule = new AdjustmentRule($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oRule->iEpisodeID      = $this->getField($data,'episode_id',$sAlias);
        $oRule->sAdjustmentRuleID = $this->getField($data,'rule_id',$sAlias);
        $oRule->sAdjustmentGroupID = $this->getField($data,'rule_group_id',$sAlias);
        $oRule->sRuleName       = $this->getField($data,'rule_name',$sAlias);
        $oRule->sRuleNameSlug   = $this->getField($data,'rule_name_slug',$sAlias);
        $oRule->fMultiplier     = $this->getField($data,'multiplier',$sAlias);
        $oRule->fModifier       = $this->getField($data,'modifier',$sAlias);
        $oRule->bInvertFlag     = (bool) $this->getField($data,'invert_flag',$sAlias);
        $oRule->oEnabledFrom    = $this->getField($data,'enabled_from',$sAlias);
        $oRule->oEnabledTo      = $this->getField($data,'enabled_to',$sAlias);
        
        $oRule->sAdjustmentGroupName = $this->getField($data,'rule_group_name','');
         
        return $oRule;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentRule    $oAdjustmentRule   the entity to convert
      */
    public function demolish($oAdjustmentRule)
    {
        return array(
            'episode_id'      => $oAdjustmentRule->iEpisodeID,
            'rule_id'         => $oAdjustmentRule->sAdjustmentRuleID,
            'rule_group_id'   => $oAdjustmentRule->sAdjustmentGroupID,
            'rule_name'       => $oAdjustmentRule->sRuleName,
            'rule_name_slug'  => $oAdjustmentRule->sRuleNameSlug,
            'enabled_from'    => $oAdjustmentRule->oEnabledFrom,
            'enabled_to'      => $oAdjustmentRule->oEnabledTo,
            'multiplier'      => $oAdjustmentRule->fMultiplier,
            'modifier'        => $oAdjustmentRule->fModifier,
            'invert_flag'     => (int)$oAdjustmentRule->bInvertFlag,
            'rule_group_name' => $oAdjustmentRule->sAdjustmentGroupName,
            
        );
        
    }
    
    
}
/* End of File */