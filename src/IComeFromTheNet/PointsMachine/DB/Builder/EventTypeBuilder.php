<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\EventType;

/**
  *  Builder for Event Type Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class EventTypeBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\EventType
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oEventType = new EventType($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oEventType->iEpisodeID        = $this->getField($data,'episode_id',$sAlias);
        $oEventType->sEventTypeID      = $this->getField($data,'event_type_id',$sAlias);
        $oEventType->sEventName        = $this->getField($data,'event_name',$sAlias);
        $oEventType->sEventNameSlug    = $this->getField($data,'event_name_slug',$sAlias);
        $oEventType->oEnabledFrom      = $this->getField($data,'enabled_from',$sAlias);
        $oEventType->oEnabledTo        = $this->getField($data,'enabled_to',$sAlias);
        
        return $oEventType;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\EventType $oEventType the entity to convert
      */
    public function demolish($oEventType)
    {
        return array(
          'episode_id'      => $oEventType->iEpisodeID,
          'event_type_id'   => $oEventType->sEventTypeID,
          'event_name'      => $oEventType->sEventName,
          'event_name_slug' => $oEventType->sEventNameSlug,
          'enabled_from'    => $oEventType->oEnabledFrom,
          'enabled_to'      => $oEventType->oEnabledTo
        );
        
    }
    
    
}
/* End of File */