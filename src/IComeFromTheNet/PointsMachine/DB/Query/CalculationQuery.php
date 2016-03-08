<?php
namespace IComeFromTheNet\PointsMachine\DB\Query;

use DateTime;
use IComeFromTheNet\PointsMachine\DB\CommonQuery;


/**
 * Builds Query for Calcualtions
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CalculationQuery extends CommonQuery
{

   /**
     * Filter by a scoring rule entity
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterByAdjustmentRuleEpisode($iEpisodeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('rule_id')->getType();
        
        return $this->andWhere($sAlias."rule_id = ".$this->createNamedParameter($iEpisodeId,$paramType));
        
    }
    
    /**
     * Filter by a the system zone
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterBySystemZoneEpisode($iEpisodeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('system_zone_id')->getType();
        
        return $this->andWhere($sAlias."system_zone_id = ".$this->createNamedParameter($iEpisodeId,$paramType));
        
    }
    
    /**
     * Filter by a the system 
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterBySystemEpisode($iEpisodeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('system_id')->getType();
        
        return $this->andWhere($sAlias."system_id = ".$this->createNamedParameter($iEpisodeId,$paramType));
        
    }
    
    /**
     * Filter by a the Adjustment Group
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterByAdjustmentGroupEpisode($iEpisodeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('rule_group_id')->getType();
        
        return $this->andWhere($sAlias."rule_group_id = ".$this->createNamedParameter($iEpisodeId,$paramType));
        
    }
    
    
    /**
     * Filter by a the Score Type
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterByScoreEpisode($iEpisodeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('score_id')->getType();
        
        return $this->andWhere($sAlias."score_id = ".$this->createNamedParameter($iEpisodeId,$paramType));
        
    }
    
    /**
     * Filter by a the Score Group 
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterByScoreGroupEpisode($iEpisodeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('score_group_id')->getType();
        
        return $this->andWhere($sAlias."score_group_id = ".$this->createNamedParameter($iEpisodeId,$paramType));
        
    }
    
    /**
     * Filter by a the Event Type
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterByEventTypeEpisode($iEpisodeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('event_type_id')->getType();
        
        return $this->andWhere($sAlias."event_type_id = ".$this->createNamedParameter($iEpisodeId,$paramType));
        
    }
    
     /**
     * Filter by a the Score Event
     * 
     * @param integer $iEpisodeId  The episode id of this entity
     * @return CommonQuery
     */ 
    public function filterByScoringEvent($iID)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('event_id')->getType();
        
        return $this->andWhere($sAlias."event_id = ".$this->createNamedParameter($iID,$paramType));
        
    }
    
    /**
     * Join this query onto the Points System databsae table
     * 
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withSystem($sAlias)
    {
        $sCurrentAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_system')
                           ->getMetaData()
                           ->getName();
        
        return $this->innerJoin($sCurrentAlias,$sTableName,$sAlias, "$sAlias.episode_id = $sCurrentAlias.system_ep");
    }
    
    /**
     * Join this query onto the Points System Zone databsae table
     * 
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withSystemZone($sAlias)
    {
        $sCurrentAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_system_zone')
                           ->getMetaData()
                           ->getName();
        
        return $this->innerJoin($sCurrentAlias,$sTableName,$sAlias, "$sAlias.episode_id = $sCurrentAlias.zone_ep");
    }


    /**
     * Join this query onto the Event Type databsae table
     * 
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withEventType($sAlias)
    {
        $sCurrentAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_event_type')
                           ->getMetaData()
                           ->getName();
        
        return $this->innerJoin($sCurrentAlias,$sTableName,$sAlias, "$sAlias.episode_id = $sCurrentAlias.event_type_ep");
    }
    
     /**
     * Join this query onto the Adjustment Group databsae table
     * 
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withAdjustmentGroup($sAlias)
    {   
        $sCurrentAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_rule_group')
                           ->getMetaData()
                           ->getName();
        
        return $this->innerJoin($sCurrentAlias,$sTableName,$sAlias, "$sAlias.episode_id = $sCurrentAlias.rule_group_ep");
    }
    
     /**
     * Join this query onto the Adjustment Rule database table
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withAdjustmentRule($sAlias)
    {   
        $sCurrentAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_rule')
                           ->getMetaData()
                           ->getName();
        
        return $this->innerJoin($sCurrentAlias,$sTableName,$sAlias, "$sAlias.episode_id = $sCurrentAlias.rule_ep");
    }
    

    /**
     * Join this query onto the Score database table
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withScore($sAlias)
    { 
        $sCurrentAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_score')
                           ->getMetaData()
                           ->getName();
        
        return $this->innerJoin($sCurrentAlias,$sTableName,$sAlias, "$sAlias.episode_id = $sCurrentAlias.score_ep");
    }
    
    
    /**
     * Join this query onto the Score Group database table
     * @return this
     * @param string    $sAlias     The Alias to use in the query
     * @access public
     */ 
    public function withScoreGroup($sAlias)
    {
        
        $sCurrentAlias   = $this->getDefaultAlias();
        
        $sTableName = $this->getGateway()
                           ->getGatewayCollection()
                           ->getGateway('pt_score_group')
                           ->getMetaData()
                           ->getName();
        
        return $this->innerJoin($sCurrentAlias,$sTableName,$sAlias, "$sAlias.episode_id = $sCurrentAlias.score_group_ep");
    }

}
/* End of Class */

