<?php
return [
   
   'pt_rule_group_limits' => [
        
        /* An entity that has been closed */
        [
             'episode_id'       => 11
            ,'rule_group_id'    => 'FB104354-BB12-CD1D-02CA-40EBE222F2E7'
            ,'score_group_id'   => '75175F0F-EA58-146E-C82F-655B7BFD786E'
            ,'system_id'        => '82F02AAA-DA4D-EFCF-B856-EADF6D365824'
            ,'enabled_from'    => (new DateTime())->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('now'))->format('Y-m-d')
        ]
        
        /* An entity that can be updated */
        ,[
             'episode_id'       => 12
            ,'rule_group_id'    => '77CE8E53-5463-8174-614F-5865A9D040A3'
            ,'score_group_id'   => '75175F0F-EA58-146E-C82F-655B7BFD786E'
            ,'system_id'        => null
            ,'enabled_from'    => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
        
        /* An entity that requires a new version */
        ,[
             'episode_id'       => 13
            ,'rule_group_id'    => 'FB104354-BB12-CD1D-02CA-40EBE222F2E7'
            ,'score_group_id'   => null
            ,'system_id'        => '8CCBB3C5-FADF-6753-CF15-985D33096691'
            ,'enabled_from'    => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('now'))->format('Y-m-d')
        ]
        
        /* A entity that was created */
        
        ,[
             'episode_id'       => 14
            ,'rule_group_id'    => '77CE8E53-5463-8174-614F-5865A9D040A3' // 2nd Test Rule Group
            ,'score_group_id'   => null
            ,'system_id'        => '82F02AAA-DA4D-EFCF-B856-EADF6D365824' // Test System
            ,'enabled_from'    => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
        /* New Version of an entity */
        ,[
             'episode_id'       => 15
            ,'rule_group_id'    => 'FB104354-BB12-CD1D-02CA-40EBE222F2E7'
            ,'score_group_id'   => '0373AA53-BEAF-534D-D943-EFD40F6F0CC1'
            ,'system_id'        => null
            ,'enabled_from'    => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
    ]
    
];