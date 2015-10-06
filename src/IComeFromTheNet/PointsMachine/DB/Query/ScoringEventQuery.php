<?php
namespace IComeFromTheNet\PointsMachine\DB;

use DBALGateway\Query\AbstractQuery;
use DateTime;

/**
 * Builds Query for Scoring Events
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class ScoringEventQuery extends AbstractQuery
{
    
    
    /**
     * Filter by a system entity
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


    
}
/* End of Class */

