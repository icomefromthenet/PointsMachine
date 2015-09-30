<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystem;

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
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\PointSystem
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oSystem = new PointSystem($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oSystem->iEpisodeID        = $this->getField($data,'episode_id',$sAlias);
        $oSystem->sSystemID         = $this->getField($data,'system_id',$sAlias);
        $oSystem->sSystemName       = $this->getField($data,'system_name',$sAlias);
        $oSystem->sSystemNameSlug   = $this->getField($data,'system_name_slug',$sAlias);
        $oSystem->oEnabledFrom      = $this->getField($data,'enabled_from',$sAlias);
        $oSystem->oEnabledTo        = $this->getField($data,'enabled_to',$sAlias);
        
        return $oSystem;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\PointSystem the entity to convert
      */
    public function demolish($oSystem)
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