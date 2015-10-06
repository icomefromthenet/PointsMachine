<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\ScoringGroup;

/**
  *  Builder for Scoring Rule Group Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class ScoringGroupBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\ScoringGroup
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oGroup = new ScoringGroup($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oGroup->iEpisodeID      = $this->getField($data,'episode_id',$sAlias);
        $oGroup->sScoringGroupID = $this->getField($data,'rule_group_id',$sAlias);
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
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\ScoringGroup    $oScoringGroup   the entity to convert
      */
    public function demolish($oScoringGroup)
    {
        return array(
            'episode_id'           => $oScoringGroup->iEpisodeID,
            'rule_group_id'         => $oScoringGroup->sScoringGroupID,
            'rule_group_name'       => $oScoringGroup->sGroupName,
            'rule_group_name_slug'  => $oScoringGroup->sGroupNameSlug,
            'enabled_from'          => $oScoringGroup->oEnabledFrom,
            'enabled_to'            => $oScoringGroup->oEnabledTo,
            'max_multiplier'        => $oScoringGroup->fMaxMultiplier,
            'min_multiplier'        => $oScoringGroup->fMinMultiplier,
            'max_modifier'          => $oScoringGroup->fMaxModifier,
            'min_modifier'          => $oScoringGroup->fMinModifier,
            'max_count'             => $oScoringGroup->iMaxCount,
            'order_method'          => $oScoringGroup->iOrderMethod,
            'is_mandatory'          => (int) $oScoringGroup->bIsMandatory,
        );
        
    }
    
    
}
/* End of File */