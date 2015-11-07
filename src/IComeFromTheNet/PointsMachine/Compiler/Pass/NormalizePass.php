<?php
namespace IComeFromTheNet\PointsMachine\Compiler\Pass;

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use DBALGateway\Table\GatewayProxyCollection;
use Doctrine\DBAL\Types\Type;
use IComeFromTheNet\PointsMachine\Compiler\CompileResult;
use IComeFromTheNet\PointsMachine\PointsMachineException;

/**
 * This process the normalize the score values
 * 
 * CURRENT is the processing date.
 * 
 * This will process the invert flag on each rule and
 * grab any overrides prior.
 * 
 * 1. Check if this rule has no override
 * 2. If invert flag set change invert (1/x) the multiplier.
 * 3. Calculate a max value of this pair (mod * mult)
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class NormalizePass extends AbstractPass 
{
    

    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            $sRankTmpTableName  = $this->getRankTmpTableName();
            $sCJoinTmpTableName = $this->getCJoinTmpTableName();
            $sRuleTmpTableName  = $this->getRuleTmpTableName();
            $sRuleTableName  = $this->getRuleTableName();
            
            # normalize each value but respect the overrides.
        
            $sSql  = " UPDATE $sRuleTmpTableName k";
            $sSql .= " SET override_modifier = IFNULL(override_modifier, ("; 
                        $sSql .= " SELECT r.modifier ";
                        $sSql .= " FROM  $sRuleTableName r ";
                        $sSql .= " WHERE  k.rule_id = r.rule_id ";
            $sSql .= ")) ";
            $sSql .= " ,override_multiplier = IFNULL(override_multiplier, ("; 
                            $sSql .= " SELECT (CASE WHEN (r.invert_flag = 1) ";
                                    $sSql .= " THEN 1 / r.multiplier ";
                                    $sSql .= " ELSE r.multiplier ";
                                $sSql .= " END) ";
                        $sSql .= " FROM  $sRuleTableName r ";
                        $sSql .= " WHERE  k.rule_id = r.rule_id ";
            $sSql .= ")) ";
            
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
    
            # Max values to be used in ordering the rules within a group
            
            $sSql  = " UPDATE $sRuleTmpTableName ";
            $sSql .= " SET max_value = (ifnull(override_modifier,1) * ifnull(override_multiplier,1)) ";        
            
            $this->getDatabaseAdaper()->executeUpdate($sSql);
        
        }
        catch(DBALException $e) {
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
        
    }
    
    
    
    
    
}
/* End of Class */