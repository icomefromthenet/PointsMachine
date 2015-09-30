<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;

/**
  *  Builder for PointSystem Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class PointSystemBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return mixed
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oSystem = new PointSystem($this->oGateway, $this->oLogger);
        
        $oSystem->iEpisodeID        = $data['episode_id'];
        $oSystem->sSystemID         = $data['system_id'];
        $oSystem->sSystemName       = $data['system_name'];
        $oSystem->sSystemNameSlug   = $data['system_name_slug'];
        $oSystem->oEnabledFrom      = $data['enabled_from'];
        $oSystem->oEnabledTo        = $data['enabled_to'];
        
        return $oSystem;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      */
    public function demolish($entity)
    {
        return array(
          'episode_id'  => $oSystem->iEpisodeID,
          'system_id'   => $oSystem->sSystemID,
          'system_name' => $oSystem->sSystemName,
          'system_name_slug' => $oSystem->sSystemNameSlug,
          'enabled_from' => $oSystem->oEnabledFrom,
          'enabled_to'   => $oSystem->oEnabledTo
        );
        
    }
    
    
}
/* End of File */