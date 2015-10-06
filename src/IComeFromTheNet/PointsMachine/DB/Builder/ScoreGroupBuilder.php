<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\ScoreGroup;

/**
  *  Builder for Score Group Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class ScoreGroupBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\ScoreGroup
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oScoreGroup = new ScoreGroup($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oScoreGroup->iEpisodeID        = $this->getField($data,'episode_id',$sAlias);
        $oScoreGroup->sScoreGroupID     = $this->getField($data,'score_group_id',$sAlias);
        $oScoreGroup->sGroupName        = $this->getField($data,'group_name',$sAlias);
        $oScoreGroup->sGroupNameSlug    = $this->getField($data,'group_name_slug',$sAlias);
        $oScoreGroup->oEnabledFrom      = $this->getField($data,'enabled_from',$sAlias);
        $oScoreGroup->oEnabledTo        = $this->getField($data,'enabled_to',$sAlias);
        
        return $oScoreGroup;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\ScoreGroup $oScoreGroup the entity to convert
      */
    public function demolish($oScoreGroup)
    {
        return array(
          'episode_id'      => $oScoreGroup->iEpisodeID,
          'score_group_id'  => $oScoreGroup->sScoreGroupID,
          'group_name'      => $oScoreGroup->sGroupName,
          'group_name_slug' => $oScoreGroup->sGroupNameSlug,
          'enabled_from'    => $oScoreGroup->oEnabledFrom,
          'enabled_to'      => $oScoreGroup->oEnabledTo
        );
        
    }
    
    
}
/* End of File */