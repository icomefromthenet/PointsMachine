<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\Score;

/**
  *  Builder for Score Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class ScoreBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\Score
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oScore = new Score($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oScore->iEpisodeID        = $this->getField($data,'episode_id',$sAlias);
        $oScore->sScoreID          = $this->getField($data,'score_id',$sAlias);
        $oScore->sScoreGroupID     = $this->getField($data,'score_group_id',$sAlias);    
        $oScore->sScoreName        = $this->getField($data,'score_name',$sAlias);
        $oScore->sScoreNameSlug    = $this->getField($data,'score_name_slug',$sAlias);
        $oScore->oEnabledFrom      = $this->getField($data,'enabled_from',$sAlias);
        $oScore->oEnabledTo        = $this->getField($data,'enabled_to',$sAlias);
        $oScore->fScoreValue       = $this->getField($data,'score_value',$sAlias);
        
        return $oScore;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\Score $oScore the entity to convert
      */
    public function demolish($oScore)
    {
        return array(
          'episode_id'      => $oScore->iEpisodeID,
          'score_id'        => $oScore->sScoreID,
          'score_group_id'  => $oScore->sScoreGroupID,
          'score_name'      => $oScore->sScoreName,
          'score_name_slug' => $oScore->sScoreNameSlug,
          'enabled_from'    => $oScore->oEnabledFrom,
          'enabled_to'      => $oScore->oEnabledTo,
          'score_value'     => $oScore->fScoreValue
        );
        
    }
    
    
}
/* End of File */