<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;

/**
 * Builds Query for Adjustment Rules
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentRuleQuery extends CommonQuery
{

   /**
     * Filter by a scoring rule entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByAdjustmentRule($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('rule_id')->getType();
        
        return $this->andWhere($sAlias."rule_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    /**
     * Filter by a scoring rule group entity
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
     * Filter by a scoring rule entity using name
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByNameLike($sSlugName)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('rule_name_slug')->getType();
        
        return $this->andWhere($sAlias."rule_name_slug LIKE ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    
    /**
     * Join this query onto the Adj Groups database table
     * 
     * Where looking for the adj group that is valid for the entire
     * validity period of this adj rule. 
     * 
     * @return this
     * 
     * @param string    $sAdjGroupAlias     The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withAdjustmentGroup($sAdjGroupAlias, DateTime $oProcessingDate)
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
            $sSql .=" AND $sAdjGroupAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sAdjGroupAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }     
        
        return $this->innerJoin($sAlias,$sTableName,$sAdjGroupAlias, $sSql);
    }

}
/* End of Class */

