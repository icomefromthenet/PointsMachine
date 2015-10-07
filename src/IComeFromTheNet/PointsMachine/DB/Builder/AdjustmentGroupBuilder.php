<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroup;

/**
  *  Builder for Scoring Rule Group Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class AdjustmentGroupBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroup
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oGroup = new AdjustmentGroup($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oGroup->iEpisodeID      = $this->getField($data,'episode_id',$sAlias);
        $oGroup->sAdjustmentGroupID = $this->getField($data,'rule_group_id',$sAlias);
        $oGroup->sGroupName      = $this->getField($data,'rule_group_name',$sAlias);
        $oGroup->sGroupNameSlug  = $this->getField($data,'rule_group_name_slug',$sAlias);
        $oGroup->fMaxMultiplier  = $this->getField($data,'max_multiplier',$sAlias);
        $oGroup->fMinMultiplier  = $this->getField($data,'min_multiplier',$sAlias);
        $oGroup->fMaxModifier    = $this->getField($data,'max_modifier',$sAlias);
        $oGroup->fMinModifier    = $this->getField($data,'min_modifier',$sAlias);  
        $oGroup->iMaxCount       = $this->getField($data,'max_count',$sAlias);
        $oGroup->iOrderMethod    = $this->getField($data,'order_method',$sAlias);
        $oGroup->bIsMandatory    = (bool) $this->getField($data,'is_mandatory',$sAlias); 
        $oGroup->oEnabledFrom    = $this->getField($data,'enabled_from',$sAlias);
        $oGroup->oEnabledTo      = $this->getField($data,'enabled_to',$sAlias);
         
        return $oGroup;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroup    $oAdjustmentGroup   the entity to convert
      */
    public function demolish($oAdjustmentGroup)
    {
        return array(
            'episode_id'           => $oAdjustmentGroup->iEpisodeID,
            'rule_group_id'         => $oAdjustmentGroup->sAdjustmentGroupID,
            'rule_group_name'       => $oAdjustmentGroup->sGroupName,
            'rule_group_name_slug'  => $oAdjustmentGroup->sGroupNameSlug,
            'enabled_from'          => $oAdjustmentGroup->oEnabledFrom,
            'enabled_to'            => $oAdjustmentGroup->oEnabledTo,
            'max_multiplier'        => $oAdjustmentGroup->fMaxMultiplier,
            'min_multiplier'        => $oAdjustmentGroup->fMinMultiplier,
            'max_modifier'          => $oAdjustmentGroup->fMaxModifier,
            'min_modifier'          => $oAdjustmentGroup->fMinModifier,
            'max_count'             => $oAdjustmentGroup->iMaxCount,
            'order_method'          => $oAdjustmentGroup->iOrderMethod,
            'is_mandatory'          => (int) $oAdjustmentGroup->bIsMandatory,
        );
        
    }
    
    
}
/* End of File */