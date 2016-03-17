<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;

/**
 * Builds Query for Rule Chain
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class RuleChainMemberQuery extends CommonQuery
{

   /**
     * Filter by a rule chain member entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByChainMember($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('chain_member_id')->getType();
        
        return $this->andWhere($sAlias."chain_member_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
  
   /**
     * Filter by a rule chain entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByRuleChain($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('rule_chain_id')->getType();
        
        return $this->andWhere($sAlias."rule_chain_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    /**
     * Filter by a Adjustment Group entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByAdjustmentGroup($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('rule_group_id')->getType();
        
        return $this->andWhere($sAlias."rule_group_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
   
    /**
     * Join this query onto the Rule Chain database table
     * 
     * @return this
     * @param string    $sRuleChainAlias   The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withRuleChain($sRuleChainAlias, DateTime $oProcessingDate)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_rule_chain')
                           ->getMetaData()
                           ->getName();
        
        
        $paramTypeTo   =  $this->getGateway()->getMetaData()->getColumn('enabled_to')->getType();
        $paramTypeFrom =  $this->getGateway()->getMetaData()->getColumn('enabled_from')->getType();
    
        
        $sSql  =" $sRuleChainAlias.rule_chain_id = $sAlias.rule_chain_id ";
        
         if($oProcessingDate->format('Y-m-d') === '3000-01-01') {
            
            $sSql .=" AND $sRuleChainAlias.enabled_to = ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);

        } else {
   
        
            // Adj Group is enabled before this processing date and valid after 
            $sSql .=" AND $sSystemAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sSystemAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->innerJoin($sAlias,$sTableName,$sRuleChainAlias, $sSql);
    }
    
    /**
     * Join this query onto the Adj Group database table
     * 
     * @return this
     * @param string    $sAdjGroupAlias   The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withAjustmentGroup($sAdjGroupAlias, DateTime $oProcessingDate)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_rule_group')
                           ->getMetaData()
                           ->getName();
        
        
        $paramTypeTo   =  $this->getGateway()->getMetaData()->getColumn('enabled_to')->getType();
        $paramTypeFrom =  $this->getGateway()->getMetaData()->getColumn('enabled_from')->getType();
    
        
        $sSql  =" $sAdjGroupAlias.rule_group_id = $sAlias.rule_group_id ";
        
         if($oProcessingDate->format('Y-m-d') === '3000-01-01') {
            
            $sSql .=" AND $sAdjGroupAlias.enabled_to = ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);

        } else {
   
        
            // Adj Group is enabled before this processing date and valid after 
            $sSql .=" AND $sSystemAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sSystemAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->innerJoin($sAlias,$sTableName,$sAdjGroupAlias, $sSql);
    }
}
/* End of Class */

