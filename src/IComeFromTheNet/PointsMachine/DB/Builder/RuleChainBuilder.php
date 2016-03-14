<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\RuleChain;

/**
  *  Builder for rule Chain Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class RuleChainBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\RuleChain
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oChain = new RuleChain($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oChain->iEpisodeID      = $this->getField($data,'episode_id',$sAlias);
        $oChain->sRuleChainID    = $this->getField($data,'rule_chain_id',$sAlias);
        $oChain->sEventTypeID    = $this->getField($data,'event_type_id',$sAlias);
        $oChain->sSystemID       = $this->getField($data,'system_id',$sAlias);
        $oChain->sChainName      = $this->getField($data,'chain_name',$sAlias);
        $oChain->sChainNameSlug  = $this->getField($data,'chain_name_slug',$sAlias);
        $oChain->iRoundingOption = $this->getField($data,'rounding_option',$sAlias);
        $oChain->fCapValue       = $this->getField($data,'cap_value',$sAlias);
        $oChain->oEnabledFrom    = $this->getField($data,'enabled_from',$sAlias);
        $oChain->oEnabledTo      = $this->getField($data,'enabled_to',$sAlias);
        $oChain->sSystemName     = $this->getField($data,'system_name','');
        $oChain->sEventTypeName  = $this->getField($data,'event_name','');
         
        return $oChain;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\RuleChain   $oRuleChain   the entity to convert
      */
    public function demolish($oRuleChain)
    {
        return array(
            'episode_id'            => $oRuleChain->iEpisodeID,
            'rule_chain_id'         => $oRuleChain->sRuleChainID,
            'event_type_id'         => $oRuleChain->sEventTypeID,
            'system_id'             => $oRuleChain->sSystemID,
            'chain_name'            => $oRuleChain->sChainName,
            'chain_name_slug'       => $oRuleChain->sChainNameSlug,
            'rounding_option'       => $oRuleChain->iRoundingOption,
            'cap_value'             => $oRuleChain->fCapValue,
            'enabled_from'          => $oRuleChain->oEnabledFrom,
            'enabled_to'            => $oRuleChain->oEnabledTo,
            'system_name'           => $oRuleChain->sSystemName,
            'event_name'       => $oRuleChain->sEventTypeName,
        );
        
    }
    
    
}
/* End of File */