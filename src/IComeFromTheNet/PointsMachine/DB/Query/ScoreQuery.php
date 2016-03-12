<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;

/**
 * Builds Query for Score Types
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoreQuery extends CommonQuery
{

   /**
     * Filter by a score entity
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByScore($sGUID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('score_id')->getType();
        
        return $this->andWhere($sAlias."score_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    /**
     * Filter by a score group entity
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
        
        return $this->andWhere($sAlias."score_group_id = ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    
   
    /**
     * Filter by a score group name 
     * 
     * @param integer $id  The GUID of this entity
     * @return CommonQuery
     */ 
    public function filterByScoreNameLike($sSlugName)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('score_name_slug')->getType();
        
        return $this->andWhere($sAlias."score_name_slug LIKE ".$this->createNamedParameter($sGUID,$paramType));
        
    }
    
    /**
     * Join this query onto the Score Groups database table
     * 
     * Where looking for the score group that is valid for the entire
     * validity period of this score. 
     * 
     * @return this
     * @param string    $sScoreGroupAlias     The Alias to use in the query
     * @access public
     */ 
    public function withScoreGroup($sScoreGroupAlias)
    {
        $sAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_score_group')
                           ->getMetaData()
                           ->getName();
        
        $sSql  =" $sScoreGroupAlias.score_group_id = $sAlias.score_group_id ";
        
        // Score Group is valid on or before this score 
        $sSql .="AND $sScoreGroupAlias.enabled_from <= $sAlias.enabled_from ";
        
        // Score Group is valid on or after this score
        $sSql .="AND $sScoreGroupAlias.enabled_to >= $sAlias.enabled_to ";
        
        
        return $this->innerJoin($sAlias,$sTableName,$sScoreGroupAlias, $sSql);
    }

}
/* End of Class */

