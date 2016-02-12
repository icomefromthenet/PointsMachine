<?php
return [
  'pt_system' => [
        /* Normal system */
        [
            'episode_id' => 2
            ,'system_id'  => '82F02AAA-DA4D-EFCF-B856-EADF6D365824'
            ,'system_name' => 'Test System'
            ,'system_name_slug' => 'test_system'
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
        ] 
        
        /* Another Normal system */
        ,[
            'episode_id' => 3
            ,'system_id'  => '8CCBB3C5-FADF-6753-CF15-985D33096691'
            ,'system_name' => '2nd Test System'
            ,'system_name_slug' => '2nd_test_system'
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
        ]  
       
       /* Expired System */
        ,[
            'episode_id' => 4
            ,'system_id'  => 'A9BE3A0B-B93F-ACC7-8811-A4554A3CEB79'
            ,'system_name' => 'Expired System'
            ,'system_name_slug' => 'expired_system'
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to'   => (new DateTime('now'))->format('Y-m-d')
        ]   
   ]
  
  ,'pt_rule_group' => [
         [
                
            'episode_id' => 3
            ,'rule_group_id' => 'FB104354-BB12-CD1D-02CA-40EBE222F2E7'
            ,'rule_group_name' => 'Test Rule Group'
            ,'rule_group_name_slug'=> 'test_rule_group'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 10
            ,'min_modifier' => 0.7
            ,'max_count' => 5
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        ,[
                
            'episode_id' => 4
            ,'rule_group_id' => '77CE8E53-5463-8174-614F-5865A9D040A3'
            ,'rule_group_name' => '2nd Test Rule Group'
            ,'rule_group_name_slug'=> '2nd_test_rule_group'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 10
            ,'min_modifier' => 0.7
            ,'max_count' => 5
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
        
      
       /* Expired Rule Group*/
      ,[
                
            'episode_id' => 5
            ,'rule_group_id' => 'D1E9AFFC-519C-807C-9EF1-3841359EF250'
            ,'rule_group_name' => 'Expired Test Rule Group'
            ,'rule_group_name_slug'=> 'expired_test_rule_group'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 10
            ,'min_modifier' => 0.7
            ,'max_count' => 5
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
        ]
   ]
   
    
    ,'pt_score_group' => [
         [
            'episode_id'       => 5
            ,'score_group_id'  => '75175F0F-EA58-146E-C82F-655B7BFD786E'
            ,'group_name'      => 'Test Score Group'
            ,'group_name_slug' => 'test_score_group'
            ,'enabled_from'    => (new DateTime())->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            
        ]
        ,[
            'episode_id'       => 6
            ,'score_group_id'  => '0373AA53-BEAF-534D-D943-EFD40F6F0CC1'
            ,'group_name'      => '2nd Test Score Group'
            ,'group_name_slug' => '2nd_test_score_group'
            ,'enabled_from'    => (new DateTime())->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            
        ]
        /* Expired Score Group */
        ,[
            'episode_id'       => 7
            ,'score_group_id'  => '489F52A7-26DF-311A-F651-2EE6D0380A48'
            ,'group_name'      => 'Expired Test Score Group'
            ,'group_name_slug' => 'expired_test_score_group'
            ,'enabled_from'    => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('now'))->format('Y-m-d')
            
        ]
        
    ]
    
    ,'pt_rule_group_limits' => [
        
        /* An entity that can be closed */
        [
             'episode_id'       => 11
            ,'rule_group_id'    => 'FB104354-BB12-CD1D-02CA-40EBE222F2E7'
            ,'score_group_id'   => '75175F0F-EA58-146E-C82F-655B7BFD786E'
            ,'system_id'        => '82F02AAA-DA4D-EFCF-B856-EADF6D365824'
            ,'enabled_from'    => (new DateTime())->format('Y-m-d')
            ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
        /* An entity that can be updated */
        ,[
             'episode_id'       => 12
            ,'rule_group_id'    => '77CE8E53-5463-8174-614F-5865A9D040A3'
            ,'score_group_id'   => '75175F0F-EA58-146E-C82F-655B7BFD786E'
            ,'system_id'        => '82F02AAA-DA4D-EFCF-B856-EADF6D365824'
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
            ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
        
    ]
    
];