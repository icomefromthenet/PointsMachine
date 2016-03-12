<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;

/**
 * Builds Query for Points Systems Zones
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class PointSystemZoneQuery extends CommonQuery
{

   /**
     * Filter by a system entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterBySystem($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('system_id')->getType();
        
        return $this->andWhere($sAlias."system_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    /**
     * Filter by a the zone identity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByZone($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('zone_id')->getType();
        
        return $this->andWhere($sAlias."zone_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
   
    /**
     * Filter by a system entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByZoneNameLike($sSlugName)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('zone_name_slug')->getType();
        
        return $this->andWhere($sAlias."zone_name_slug LIKE ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    
    /**
     * Join this query onto the Points System databsae table
     * 
     * Where looking for the system that is valid for the entire
     * validity period of this zone. ie fills
     * 
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withSystem($sSystemAlias)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_system')
                           ->getMetaData()
                           ->getName();
        
        $sSql  =" $sSystemAlias.system_id = $sAlias.system_id ";
        
        // System is valid on or before this zone 
        $sSql .="AND $sSystemAlias.enabled_from <= $sAlias.enabled_from ";
        
        // System is valid on or after this zone
        $sSql .="AND $sSystemAlias.enabled_to >= $sAlias.enabled_to ";
        
        
        return $this->innerJoin($sAlias,$sTableName,$sSystemAlias, $sSql);
    }

}
/* End of Class */

