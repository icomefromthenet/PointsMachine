<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;

/**
 * Builds Query for Adjustment Zones
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentZoneQuery extends CommonQuery
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
     * Filter by a the system zone
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterBySystemZone($sGUID)
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
     * Join this query onto the Adj Rule database table
     * 
     * 
     * @return this
     * @param string    $sAdjAlias          The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withAdjustmentRule($sAdjAlias, DateTime $oProcessingDate)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_rule')
                           ->getMetaData()
                           ->getName();
        
        
        $paramTypeTo   =  $this->getGateway()->getMetaData()->getColumn('enabled_to')->getType();
        $paramTypeFrom =  $this->getGateway()->getMetaData()->getColumn('enabled_from')->getType();
    
        
        $sSql  =" $sAdjAlias.rule_id = $sAlias.rule_id ";
        
        if($oProcessingDate->format('Y-m-d') === '3000-01-01') {
            
            $sSql .=" AND $sAdjAlias.enabled_to = ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);

        } else {
   
        
            // Adj Group is enabled before this processing date and valid after 
            $sSql .=" AND $sAdjAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sAdjAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->innerJoin($sAlias,$sTableName,$sAdjAlias, $sSql);
    }
    
    /**
     * Join this query onto the System Zone database table
     * 
     * @return this
     * @param string    $sSystemZoneAlias   The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withSystemZone($sSystemZoneAlias, DateTime $oProcessingDate)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_system_zone')
                           ->getMetaData()
                           ->getName();
        
        
        $paramTypeTo   =  $this->getGateway()->getMetaData()->getColumn('enabled_to')->getType();
        $paramTypeFrom =  $this->getGateway()->getMetaData()->getColumn('enabled_from')->getType();
    
        
        $sSql  =" $sSystemZoneAlias.zone_id = $sAlias.zone_id ";
        
         if($oProcessingDate->format('Y-m-d') === '3000-01-01') {
            
            $sSql .=" AND $sSystemZoneAlias.enabled_to = ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);

        } else {
   
        
            // Adj Group is enabled before this processing date and valid after 
            $sSql .=" AND $sSystemZoneAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sSystemZoneAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->innerJoin($sAlias,$sTableName,$sSystemZoneAlias, $sSql);
    }
  

}
/* End of Class */

