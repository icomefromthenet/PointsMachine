<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\PointSystemZone;

/**
  *  Builder for PointSystemZone Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class PointSystemZoneBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\PointSystemZone
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oSystem = new PointSystemZone($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oSystem->iEpisodeID        = $this->getField($data,'episode_id',$sAlias);
        $oSystem->sZoneID           = $this->getField($data,'zone_id',$sAlias);
        $oSystem->sSystemID         = $this->getField($data,'system_id',$sAlias);
        $oSystem->sZoneName         = $this->getField($data,'zone_name',$sAlias);
        $oSystem->sZoneNameSlug     = $this->getField($data,'zone_name_slug',$sAlias);
        $oSystem->oEnabledFrom      = $this->getField($data,'enabled_from',$sAlias);
        $oSystem->oEnabledTo        = $this->getField($data,'enabled_to',$sAlias);
        
        return $oSystem;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\PointSystemZone the entity to convert
      */
    public function demolish($oSystemZone)
    {
        return array(
          'episode_id'      => $oSystemZone->iEpisodeID,
          'zone_id'         => $oSystemZone->sZoneID,
          'system_id'       => $oSystemZone->sSystemID,
          'zone_name'       => $oSystemZone->sZoneName,
          'zone_name_slug'  => $oSystemZone->sZoneNameSlug,
          'enabled_from'    => $oSystemZone->oEnabledFrom,
          'enabled_to'      => $oSystemZone->oEnabledTo
        );
        
    }
    
    
}
/* End of File */