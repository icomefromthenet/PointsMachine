<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentZone;

/**
  *  Builder for Scoring Rules System Zones Relations
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class AdjustmentZoneBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentZone
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oRule = new AdjustmentZone($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oRule->iEpisodeID      = $this->getField($data,'episode_id',$sAlias);
        $oRule->sAdjustmentRuleID = $this->getField($data,'rule_id',$sAlias);
        $oRule->sSystemZoneID   = $this->getField($data,'zone_id',$sAlias);
        $oRule->oEnabledFrom    = $this->getField($data,'enabled_from',$sAlias);
        $oRule->oEnabledTo      = $this->getField($data,'enabled_to',$sAlias);
         
        return $oRule;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\AdjustmentZone    $oAdjustmentZone   the entity to convert
      */
    public function demolish($oAdjustmentZone)
    {
        return array(
            'episode_id'      => $oAdjustmentZone->iEpisodeID,
            'rule_id'         => $oAdjustmentZone->sAdjustmentRuleID,
            'zone_id'         => $oAdjustmentZone->sSystemZoneID,
            'enabled_from'    => $oAdjustmentZone->oEnabledFrom,
            'enabled_to'      => $oAdjustmentZone->oEnabledTo,
        );
        
    }
    
    
}
/* End of File */