<?php
namespace IComeFromTheNet\PointsMachine\DB;

use DBALGateway\Builder\AliasBuilder;
use DBALGateway\Table\AbstractTable;
use Psr\Log\LoggerInterface;

/**
  * A common builder that needed for common setters 
  * these dependecies are used by entities. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
abstract class CommonBuilder extends AliasBuilder 
{
    
    /**
     * @var DBALGateway\Table\AbstractTable
     */ 
    protected $oGateway;
    
    /**
     * @var Psr\Log\LoggerInterface
     */ 
    protected $oLogger;   
    
   
   public function setGateway(AbstractTable $oGateway)
   {
        $this->oGateway = $oGateway;
   }
   
   public function setLogger(LoggerInterface $oLogger)
   {
       $this->oLogger  = $oLogger;
   }
   
   
   /**
     * If alias exists fetch field using its alias name, if alias is empty
     * use the normal field name to return the value at that index
     * 
     * If index does not exist
     * 
     * @return mixed the field at the index
     * @param   array   $aResult    The result from the database query
     * @param   string  $sField     The no-alias field name
     * @param   string  $sAlias     The Alias assigned 
     * @param   string  $mDefault   A default value to use
     */ 
    protected function getField(array &$aResult,$sField,$sAlias, $mDefault = null)
    {
        $mResult = $mDefault;
        
        if(false === empty($sAlias)) {
           $sFullIndex = $sAlias.'_'.$sField;
        } 
        else {
            $sFullIndex = $sField;
        }
        
               
        if(true === array_key_exists($sFullIndex,$aResult)) {
               $mResult = $aResult[$sFullIndex];
        } 
        
        return $mResult;
        
    }
 
    
}
/* End of File */