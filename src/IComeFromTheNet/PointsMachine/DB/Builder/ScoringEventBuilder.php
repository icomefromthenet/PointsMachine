<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\ScoringEvent;

/**
  *  Builder for Scoring Event Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class PointSystemZoneBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\ScoringEvent
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oEvent = new ScoringEvent($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oEvent->sScoringEventID = $this->getField($data,'event_id',$sAlias);
        $oEvent->sEventTypeID    = $this->getField($data,'event_type_id',$sAlias);
        $oEvent->oCreateDate     = $this->getField($data,'event_created',$sAlias);
        $oEvent->oProcessDate    = $this->getField($data,'process_date',$sAlias);
        
        
        return $oSystem;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\ScoringEvent    $oScoringEvent   the entity to convert
      */
    public function demolish($oScoringEvent)
    {
        return array(
          'event_id'        => $oSystemZone->sScoringEventID,
          'event_type_id'   => $oSystemZone->sEventTypeID,
          'event_created'   => $oSystemZone->oCreateDate,
          'process_date'    => $oSystemZone->oProcessDate,
        );
        
    }
    
    
}
/* End of File */