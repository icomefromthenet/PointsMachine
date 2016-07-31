<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;

/**
 * Builds Query for Adjustment Groups Limits
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class AdjustmentGroupLimitQuery extends CommonQuery
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
     * Filter by a scoring rule entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByScoreGroup($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('score_group_id')->getType();
        
        $this->andWhere($sAlias."system_id IS NULL");
        
        return $this->andWhere($sAlias."score_group_id = ".$this->createNamedParameter($sGUID,$paramType));
        
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
        
        $this->andWhere($sAlias."score_group_id IS NULL");
        
        return $this->andWhere($sAlias."system_id = ".$this->createNamedParameter($sGUID,$paramType));
        
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
        
        return $this->leftJoin($sAlias,$sTableName,$sSystemAlias, $sSql);
    }
    
    
    /**
     * Join this query onto the Score Group database table
     * 
     * @return this
     * @param string    $sScoreGroupAlias   The Alias to use in the query
     * @param DateTime  $oProcessingDate    The Processing Date
     * @access public
     */ 
    public function withScoreGroup($sScoreGroupAlias, DateTime $oProcessingDate)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_score_group')
                           ->getMetaData()
                           ->getName();
        
        
        $paramTypeTo   =  $this->getGateway()->getMetaData()->getColumn('enabled_to')->getType();
        $paramTypeFrom =  $this->getGateway()->getMetaData()->getColumn('enabled_from')->getType();
    
        
        $sSql  =" $sScoreGroupAlias.score_group_id = $sAlias.score_group_id ";
        
         if($oProcessingDate->format('Y-m-d') === '3000-01-01') {
            
            $sSql .=" AND $sScoreGroupAlias.enabled_to = ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);

        } else {
   
        
            // Adj Group is enabled before this processing date and valid after 
            $sSql .=" AND $sSystemAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sSystemAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->leftJoin($sAlias,$sTableName,$sScoreGroupAlias, $sSql);
    }
    
    
    /**
     * Join this query onto the Adjustment Group database table
     * 
     * @return this
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
            $sSql .=" AND $sSystemAlias.enabled_from <= ".$this->createNamedParameter($oProcessingDate,$paramTypeFrom);
            $sSql .=" AND $sSystemAlias.enabled_to > ".$this->createNamedParameter($oProcessingDate,$paramTypeTo);
        
        }
        
        return $this->innerJoin($sAlias,$sTableName,$sAdjGroupAlias, $sSql);
    }
   

}
/* End of Class */

