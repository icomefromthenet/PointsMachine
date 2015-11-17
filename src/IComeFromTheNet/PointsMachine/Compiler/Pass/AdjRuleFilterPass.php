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
 * This process the rules tmp table 
 * 
 * CURRENT is the processing date.
 * 
 * 1. match rules to groups and find the episodes
 * 2. filter out rules that dont apply to current zone
 * 3. remove rule groups with no episodes
 * 4. find the chain member and remove if one exist
 * 5. remove groups that don't apply to current score group
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AdjRuleFilterPass extends AbstractPass 
{
    
    
    const PASS_PRIORITY = 30;
    
    
    
    protected function matchRule(DateTime $oProcessingDate)
    {
        $sSql            = '';
        $sRuleTmpTable   = $this->getRuleTmpTableName();
        $sCommonTmpTable = $this->getCommonTmpTableName();
        $sRuleTable      = $this->getRuleTableName();                  
        
        $sRuleZoneTable = $this->getGatewayCollection()
                               ->getGateway('pt_rule_sys_zone')
                                ->getMetaData()
                                ->getName();    
                            
        
        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET  k.rule_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sRuleTable.' j, '.$sCommonTmpTable  .' l ';
            $sSql .= 'WHERE  j.enabled_from <= l.processing_date AND j.enabled_to > l.processing_date ';
            $sSql .= 'AND j.rule_id = k.rule_id ';
        $sSql .= ');'.PHP_EOL;
       
        
        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= ' SET k.rule_group_id = (';
            $sSql .= 'SELECT j.rule_group_id ';
            $sSql .= 'FROM  '.$sRuleTable.' j, '.$sCommonTmpTable  .' l ';
            $sSql .= 'WHERE  j.enabled_from <= l.processing_date AND j.enabled_to > l.processing_date ';
            $sSql .= 'AND j.rule_id = k.rule_id ';
        $sSql .= ');'.PHP_EOL;
        
        
        
        # Remove rules that have a zone link that not match the assigned zone
        
        # However a rule that links to no zones applies to all.
    
        # Remove any rules without an episode
        
        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET k.apply_all_zone = IF(( ';
                            $sSql .= 'SELECT count(*) FROM '.$sRuleZoneTable.' j ,'.$sCommonTmpTable.' l ';
                            $sSql .= 'WHERE  j.enabled_from <= l.processing_date ';
                            $sSql .= 'AND j.enabled_to > l.processing_date ';
                            $sSql .= 'AND k.rule_id = j.rule_id ';
                            $sSql .=')> 0,0,1);'.PHP_EOL;
   
         
        $sSql  .= 'DELETE k FROM '.$sRuleTmpTable .' k ';    
        $sSql .= 'WHERE NOT EXISTS (SELECT 1 FROM '.$sRuleZoneTable.' j ,'.$sCommonTmpTable.' l ';
                            $sSql .= 'WHERE  j.enabled_from <= l.processing_date ';
                            $sSql .= 'AND j.enabled_to > l.processing_date ';
                            $sSql .= 'AND k.rule_id = j.rule_id ';
                            $sSql .= 'AND l.system_zone_id = j.zone_id) ';
        $sSql .= 'AND k.apply_all_zone = 0 ';        
        $sSql .= 'OR k.rule_ep IS NULL; '.PHP_EOL;
       
        
        return $sSql;
    }
    
    protected function matchRuleGroup(DateTime $oProcessingDate)
    {
        $sSql  = '';
        $sRuleTmpTable    = $this->getRuleTmpTableName();
        $sCommonTmpTable  = $this->getCommonTmpTableName();
        $sRuleGroupTable  = $this->getRuleGroupTableName();                   
        
        $sRuleLimitTable =  $this->getGatewayCollection()
                            ->getGateway('pt_rule_group_limits')
                            ->getMetaData()
                            ->getName();                    
                
        
        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET  k.rule_group_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sRuleGroupTable.' j, '.$sCommonTmpTable  .' l ';
            $sSql .= 'WHERE  j.enabled_from <= l.processing_date AND j.enabled_to > l.processing_date ';
            $sSql .= 'AND j.rule_group_id = k.rule_group_id ';
        $sSql .= ');'.PHP_EOL;
        
        

        # filter out rule groups that are not linked to the current system

        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET  k.apply_all_sys = IF((';
                    $sSql .= 'SELECT count(*) FROM '.$sRuleLimitTable.' j ,'.$sCommonTmpTable.' l ';
                    $sSql .= 'WHERE  j.enabled_from <= l.processing_date  ';
                    $sSql .= 'AND j.enabled_to > l.processing_date ';
                    $sSql .= 'AND k.rule_group_id = j.rule_group_id ';
                    $sSql .= 'AND j.system_id IS NOT NULL ';  
        $sSql .= ') > 0,0,1);'.PHP_EOL;
        
    
        $sSql .= 'DELETE k FROM '.$sRuleTmpTable .' k ';    
        $sSql .= 'WHERE NOT EXISTS ( ';
                            $sSql .= 'SELECT 1 FROM '.$sRuleLimitTable.' j ,'.$sCommonTmpTable.' l ';
                            $sSql .= 'WHERE  j.enabled_from <= l.processing_date  ';
                            $sSql .= 'AND j.enabled_to > l.processing_date ';
                            $sSql .= 'AND k.rule_group_id = j.rule_group_id ';
                            $sSql .= 'AND l.system_id = j.system_id ';
                            $sSql .= ')';
        $sSql .= 'AND k.apply_all_sys = 0;'.PHP_EOL;
        
        
        # filter out rule groups not linked to the score group
        # we won't know until we do the join on score and rules which record to filter
        # but want to know if this rule group has strict requirements
        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET  k.apply_all_score = IF((';
                    $sSql .= 'SELECT count(*) FROM '.$sRuleLimitTable.' j ,'.$sCommonTmpTable.' l ' ;
                    $sSql .= 'WHERE  j.enabled_from <= l.processing_date  ';
                    $sSql .= 'AND j.enabled_to > l.processing_date ';
                    $sSql .= 'AND k.rule_group_id = j.rule_group_id ';
                    $sSql .= 'AND j.score_group_id is not null  ';  
        $sSql .= ') > 0,0,1);'.PHP_EOL;
         
       
 
        # Remove any rules without rule group episodes
        $sSql  .= 'DELETE k FROM '.$sRuleTmpTable .' k ';   
        $sSql .= 'WHERE k.rule_group_ep IS NULL;'.PHP_EOL;
        
        
        return $sSql;

    }
    
    protected function matchRuleChainMember(DateTime $oProcessingDate)
    {
        $sSql               = '';
        $sRuleTmpTable      = $this->getRuleTmpTableName();
        $sCommonTmpTable    = $this->getCommonTmpTableName();
        $sRuleCMemberTable  = $this->getChainMemberTableName();
        
        # find the chain member entity id, this may be null if the rule group not
        # part of the chain
        
        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET  k.chain_member_id = (';
            $sSql .= 'SELECT j.chain_member_id ';
            $sSql .= 'FROM  '.$sRuleCMemberTable.' j, '.$sCommonTmpTable  .' l ';
            $sSql .= 'WHERE  j.rule_chain_id = l.rule_chain_id ';
            $sSql .= 'AND j.rule_group_id = k.rule_group_id ';
        $sSql .= '); '.PHP_EOL;
        
        
        # find the episode of this entity 
        $sSql .=  'UPDATE '.$sRuleTmpTable .' k ';
        $sSql .= 'SET k.chain_member_ep = (';
            $sSql .= 'SELECT j.episode_id ';
            $sSql .= 'FROM  '.$sRuleCMemberTable.' j, '.$sCommonTmpTable  .' l ';
            $sSql .= 'WHERE  j.enabled_from <= l.processing_date AND j.enabled_to > l.processing_date ';
            $sSql .= 'AND j.rule_chain_id = l.rule_chain_id ';
            $sSql .= 'AND j.rule_group_id = k.rule_group_id ';
        $sSql .= '); '.PHP_EOL;
        
        
        # remove adjustment groups not part of the assigned chain.
        
        $sSql .= 'DELETE k FROM '.$sRuleTmpTable .' k ';    
        $sSql .= 'WHERE k.chain_member_ep IS NULL; '.PHP_EOL;
        
        return $sSql;
    }
    
    
    /**
     * Executes this pass.
     * 
     * @return boolean true if successful.
     */ 
    public function execute(DateTime $oProcessingDate, CompileResult $oResult)
    {
        
        try {
            
            $oDatabase = $this->getDatabaseAdapter();
            
            $sSql  = '';
            $sSql .= $this->matchRule($oProcessingDate);
            $sSql .= $this->matchRuleGroup($oProcessingDate);
            $sSql .= $this->matchRuleChainMember($oProcessingDate);
           
            
            $oDatabase->executeUpdate($sSql);
            
            $oResult->addResult(__CLASS__,'Executed Successfully');
        }
        catch(DBALException $e) {
            $oResult->addError(__CLASS__,$e->getMessage());
            throw new PointsMachineException($e->getMessage(),0,$e);
            
        }
        
        
    }
    
    
    
    
    
}
/* End of Class */