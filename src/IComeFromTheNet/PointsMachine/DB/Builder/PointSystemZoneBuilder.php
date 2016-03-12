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
        $oSystemZone = new PointSystemZone($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oSystemZone->iEpisodeID        = $this->getField($data,'episode_id',$sAlias);
        $oSystemZone->sZoneID           = $this->getField($data,'zone_id',$sAlias);
        $oSystemZone->sSystemID         = $this->getField($data,'system_id',$sAlias);
        $oSystemZone->sZoneName         = $this->getField($data,'zone_name',$sAlias);
        $oSystemZone->sZoneNameSlug     = $this->getField($data,'zone_name_slug',$sAlias);
        $oSystemZone->oEnabledFrom      = $this->getField($data,'enabled_from',$sAlias);
        $oSystemZone->oEnabledTo        = $this->getField($data,'enabled_to',$sAlias);
        
        $oSystemZone->sSystemName       = $data['system_name'];
        
        return $oSystemZone;
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
          'enabled_to'      => $oSystemZone->oEnabledTo,
          'system_name'     => $oSystemZone->sSystemName,
        );
        
    }
    
    
}
/* End of File */