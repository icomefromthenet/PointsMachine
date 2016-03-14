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
class RuleChainQuery extends CommonQuery
{

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
     * Filter by a event type entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByEventType($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('event_type_id')->getType();
        
        return $this->andWhere($sAlias."event_type_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
   
    /**
     * Filter by a system entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByChainNameLike($sSlugName)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('chain_name_slug')->getType();
        
        return $this->andWhere($sAlias."chain_name_slug LIKE ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    
    /**
     * Join this query onto the System database table
     * 
     * @return this
     * @param string    $sSystemAlias   The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withSystem($sSystemAlias, DateTime $oProcessingDate)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_system')
                           ->getMetaData()
                           ->getName();
        
        
        $paramTypeTo   =  $this->getGateway()->getMetaData()->getColumn('enabled_to')->getType();
        $paramTypeFrom =  $this->getGateway()->getMetaData()->getColumn('enabled_from')->getType();
    
        
        $sSql  =" $sSystemAlias.system_id = $sAlias.system_id ";
        
         if($oProcessingDate->format('Y-m-d') === '3000-01-01') {
            
            $sSql .=" AND $sSystemAlias.enabled_to = ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);

        } else {
   
        
            // Adj Group is enabled before this processing date and valid after 
            $sSql .=" AND $sSystemAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sSystemAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->innerJoin($sAlias,$sTableName,$sSystemAlias, $sSql);
    }
    
    
    /**
     * Join this query onto the Event Type database table
     * 
     * @return this
     * @param string    $sEventTypeAlias   The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withEventType($sEventTypeAlias, DateTime $oProcessingDate)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_event_type')
                           ->getMetaData()
                           ->getName();
        
        
        $paramTypeTo   =  $this->getGateway()->getMetaData()->getColumn('enabled_to')->getType();
        $paramTypeFrom =  $this->getGateway()->getMetaData()->getColumn('enabled_from')->getType();
    
        
        $sSql  =" $sEventTypeAlias.event_type_id = $sAlias.event_type_id ";
        
         if($oProcessingDate->format('Y-m-d') === '3000-01-01') {
            
            $sSql .=" AND $sEventTypeAlias.enabled_to = ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);

        } else {
   
        
            // Adj Group is enabled before this processing date and valid after 
            $sSql .=" AND $sEventTypeAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sEventTypeAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->innerJoin($sAlias,$sTableName,$sEventTypeAlias, $sSql);
    }

}
/* End of Class */

