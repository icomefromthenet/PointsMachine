<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroupLimit;

/**
  *  Builder for Adjustment Group Limit Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class AdjustmentGroupLimitBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroupLimit
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oGroup = new AdjustmentGroupLimit($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
    
        $oGroup->iEpisodeID             = $this->getField($data,'episode_id',$sAlias);
        $oGroup->sAdjustmentGroupID     = $this->getField($data,'rule_group_id',$sAlias);
        $oGroup->sScoreGroupID          = $this->getField($data,'score_group_id',$sAlias);
        $oGroup->sSystemID              = $this->getField($data,'system_id',$sAlias);
        $oGroup->oEnabledFrom           = $this->getField($data,'enabled_from',$sAlias);
        $oGroup->oEnabledTo             = $this->getField($data,'enabled_to',$sAlias);
         
        return $oGroup;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentGroupLimit    $oAdjustmentGroupLimit   the entity to convert
      */
    public function demolish($oAdjustmentGroupLimit)
    {
        return array(
            'episode_id'             => $oAdjustmentGroupLimit->iEpisodeID,
            'rule_group_id'         => $oAdjustmentGroupLimit->sAdjustmentGroupID,
            'score_group_id'        => $oAdjustmentGroupLimit->sScoreGroupID,
            'system_id'             => $oAdjustmentGroupLimit->sSystemID,
            'enabled_from'          => $oAdjustmentGroupLimit->oEnabledFrom,
            'enabled_to'            => $oAdjustmentGroupLimit->oEnabledTo,
        );
        
    }
    
    
}
/* End of File */