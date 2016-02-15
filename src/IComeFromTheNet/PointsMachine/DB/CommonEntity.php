<?php 
namespace IComeFromTheNet\PointsMachine\DB;

use DateTime;
use DBALGateway\Table\AbstractTable;
use Psr\Log\LoggerInterface;
use Valitron\Validator;

/**
 * Entity for the points system
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
abstract class CommonEntity implements ActiveRecordInterface
{
    /**
     * @var DBALGateway\Table\AbstractTable
     */ 
    protected $oGateway;
    
    /**
     * @var Psr\Log\LoggerInterface
     */ 
    protected $oLogger;
    
    /**
     * @var array the last result query
     */ 
    protected $aLastResult;
    
    /*
    *   Taken from the PHP documentation website.
    *
    *   Kristof_Polleunis at yahoo dot com
    *
    *   A guid function that works in all php versions:
    *   MEM 3/30/2015 : Modified the function to allow someone
    *       to specify whether or not they want the curly
    *       braces on the GUID.
    *
    * @link http://php.net/manual/en/function.com-create-guid.php
    * @return string a guid
    * @access protected
    */    
    public function guid($opt = true )
    {       
        
        //  Set to true/false as your default way to do this.
        if(true === function_exists('com_create_guid')){
            if( $opt ){ 
                return com_create_guid(); 
            }
            else { 
                return trim( com_create_guid(), '{}' ); 
            }
        }
        else {
            mt_srand( (double)microtime() * 10000 );    // optional for php 4.2.0 and up.
            $charid = strtoupper( md5(uniqid(rand(), true)) );
            $hyphen = chr( 45 );    // "-"
            $left_curly = $opt ? chr(123) : "";     //  "{"
            $right_curly = $opt ? chr(125) : "";    //  "}"
            $uuid = $left_curly
                . substr( $charid, 0, 8 ) . $hyphen
                . substr( $charid, 8, 4 ) . $hyphen
                . substr( $charid, 12, 4 ) . $hyphen
                . substr( $charid, 16, 4 ) . $hyphen
                . substr( $charid, 20, 12 )
                . $right_curly;
            return $uuid;
        }
        
    }
    
    /**
     *  Class Constructor
     * 
     *  @return void
     *  @access public
     */ 
    public function __construct(AbstractTable $oGateway, LoggerInterface $oLogger) 
    {
        $this->oGateway = $oGateway;
        $this->oLogger  = $oLogger;
        
    }
    
    /**
     * Return the assigned table gateway
     * 
     * @return DBALGateway\Table\AbstractTable
     */ 
    public function getTableGateway()
    {
        return $this->oGateway;
    }
    
    
    /**
     * Return the app logger
     * 
     * @return Psr\Log\LoggerInterface
     */ 
    public function getAppLogger()
    {
        return $this->oLogger;
    }
    
    /**
     * Fetch the last query result 
     * 
     * @return array('result' => '', 'msg' =>'')
     */ 
    public function getLastQueryResult()
    {
        return $this->aLastResult;
    }
    
    
    
    
    // -------------------------------------------------------------
    #  ActiveRecordInterface
    
    
    abstract public function save();
    
    abstract public function remove();
    
    
    
    //-----------------------------------------------------------------
    # Extra Validator Helpers
    
    /**
     * Validate an object using the data and rules passed in
     * 
     * Will update the last result with validation errors
     * 
     * @param array $aData   The data to validate 
     * @param array $aRules  The results to apply
     * 
     * @return boolean true if valid false otherwise
     */ 
    protected function validate($aData,$aRules)
    {
        $oValidator = new Validator($aData);
        
        $oValidator->rules($aRules);
        
        $bValid = $oValidator->validate();
        
        if(false === $bValid) {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = $oValidator->errors();
        }
        
        return $bValid;
        
    }
    
    abstract protected function validateNew();
    
    abstract protected function validateUpdate();
          
    abstract protected function validateRemove();
}
/* End of File */
