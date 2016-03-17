<?php
namespace IComeFromTheNet\PointsMachine\DB\Builder;

use IComeFromTheNet\PointsMachine\DB\CommonBuilder;
use IComeFromTheNet\PointsMachine\DB\Entity\RuleChainMember;

/**
  *  Builder for rule Chain Entities
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class RuleChainMemberBuilder extends CommonBuilder
{
    
    
    /**
      *  Convert data array into entity
      *
      *  @return IComeFromTheNet\PointsMachine\DB\Entity\RuleChainMember
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oChain = new RuleChainMember($this->oGateway, $this->oLogger);
        $sAlias = $this->getTableQueryAlias();
        
        $oChain->iEpisodeID         = $this->getField($data,'episode_id',$sAlias);
        $oChain->sRuleChainMemberID = $this->getField($data,'chain_member_id',$sAlias);
        $oChain->sRuleChainID       = $this->getField($data,'rule_chain_id',$sAlias);
        $oChain->sAdjustmentGroupID = $this->getField($data,'rule_group_id',$sAlias);
        $oChain->iOrderSeq          = $this->getField($data,'order_seq',$sAlias);
        $oChain->oEnabledFrom       = $this->getField($data,'enabled_from',$sAlias);
        $oChain->oEnabledTo         = $this->getField($data,'enabled_to',$sAlias);
        
        $oChain->sAdjustmentGroupName = $this->getField($data,'rule_group_name','');
        $oChain->sRuleChainName       = $this->getField($data,'chain_name','');      
         
        return $oChain;
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      *  @param IComeFromTheNet\PointsMachine\DB\Entity\RuleChainMember   $oRuleChainMember   the entity to convert
      */
    public function demolish($oRuleChainMember)
    {
        return array(
            'episode_id'          => $oRuleChainMember->iEpisodeID,
            'chain_member_id'     => $oRuleChainMember->sRuleChainMemberID,
            'rule_chain_id'       => $oRuleChainMember->sRuleChainID,
            'rule_group_id'       => $oRuleChainMember->sAdjustmentGroupID,
            'order_seq'           => $oRuleChainMember->iOrderSeq,
            'enabled_from'        => $oRuleChainMember->oEnabledFrom,
            'enabled_to'          => $oRuleChainMember->oEnabledTo,
            
            'rule_group_name'     => $oRuleChainMember->sAdjustmentGroupName,
            'chain_name'          => $oRuleChainMember->sRuleChainName,
        );
        
    }
    
    
}
/* End of File */