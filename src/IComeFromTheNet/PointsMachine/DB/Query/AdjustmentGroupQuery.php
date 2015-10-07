<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;

/**
 * Builds Query for Adjustment Groups
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentGroupQuery extends CommonQuery
{

   /**
     * Filter by a scoring rule entity
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
    public function filterByGroupNameLike($sSlugName)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('rule_group_name_slug')->getType();
        
        return $this->andWhere($sAlias."rule_group_name_slug LIKE ".$this->createNamedParameter($sGUID,$paramType));
        
    }

}
/* End of Class */

