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
    

    


}
/* End of Class */

