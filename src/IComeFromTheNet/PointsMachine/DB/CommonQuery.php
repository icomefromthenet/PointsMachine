<?php
namespace IComeFromTheNet\PointsMachine\DB;

use DBALGateway\Query\AbstractQuery;
use DateTime;

/**
 * Builds Query for Points Systems
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CommonQuery extends AbstractQuery
{

    /**
     * Filter an episode ID
     * 
     * @param integer $id   The episode database id
     * @return CommonQuery
     */ 
    public function filterByEpisode($id)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('episode_id')->getType();
        
        return $this->andWhere($sAlias."episode_id = ".$this->createNamedParameter($id,$paramType));
        
    }
    
    /**
     *  Filter for entities that are enabled before but not including the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledBefore(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($sAlias."enabled_from < ".$this->createNamedParameter($oDate,$paramType));
    }
    
    /**
     *  Filter for entities that are enabled before and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledBeforeAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($sAlias."enabled_from <= ".$this->createNamedParameter($oDate,$paramType));
    }
    
     /**
     *  Filter for entities that are enabledafter but not including the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledAfter(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($sAlias."enabled_from > ".$this->createNamedParameter($oDate,$paramType));
    }
    
    /**
     *  Filter for entities that are enabled after and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledAfterAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($sAlias."enabled_from >= ".$this->createNamedParameter($oDate,$paramType));
    }
   
    /**
     *  Filter for entities that are disabled before but not including the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledBefore(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        
        return $this->andWhere($sAlias."enabled_to < ".$this->createNamedParameter($oDate,$paramType));
    }
    
    /**
     *  Filter for entities that are disabled before and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledBeforeAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        
        return $this->andWhere($sAlias."enabled_to <= ".$this->createNamedParameter($oDate,$paramType));
    }
    
    /**
     *  Filter for entities that are disabled after but not including given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledAfter(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        
        return $this->andWhere($sAlias."enabled_to > ".$this->createNamedParameter($oDate,$paramType));
    }
    
    /**
     *  Filter for entities that are disabled after and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledAfterAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        
        return $this->andWhere($sAlias."enabled_to >= ".$this->createNamedParameter($oDate,$paramType));
    }
    
    /**
     *  Find only current (enabled) entities 
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByCurrent(DateTime $oCurrent)
    {
       $this->filterByEnabledBeforeAndOn($oCurrent);
       $this->filterByDisabledAfterAndOn($oCurrent);
        
       return $this;    
    }

}
/* End of Class */

