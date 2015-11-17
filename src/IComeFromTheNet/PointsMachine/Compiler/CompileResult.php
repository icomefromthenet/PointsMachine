<?php
namespace IComeFromTheNet\PointsMachine\Compiler;


class CompileResult 
{
    /**
     * @var array the seed data
     */ 
    public $oData;
    
    /**
     * @var array a message from successful passes
     */ 
    protected $aPassResult;
    
    /**
     * @var array error messages from failed passes
     */ 
    protected $aPassErrors;
    
    
    public function __construct()
    {
        $this->aPassResult = array();
        $this->aPassErrors = array();

    }
    
    public function getSeedData()
    {
        return $this->oData;
    }
    
    
    public function getResult() 
    {
        return $this->aPassResult;
    }
    
    public function getErrors()
    {
        return $this->aPassErrors;
    }
    
    public function addResult($sPassName, $sPassMessage)
    {
        $this->aPassResult[$sPassName] = $sPassMessage;
    }
    
    public function addError($sPassName, $sPassMessage)
    {
        $this->aPassErrors[$sPassName] = $sPassMessage;
    }
    
}
/* End of Class */