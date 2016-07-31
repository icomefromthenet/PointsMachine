<?php 
return [
       'pt_rule_group' =>
        [
            /* Normal Group */
            [
                'episode_id' => 3
                ,'rule_group_id' => '644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_group_name' => 'Test Group'
                ,'rule_group_name_slug'=> 'test_group'
                ,'max_multiplier' => null
                ,'min_multiplier' => null
                ,'max_modifier' => 5
                ,'min_modifier' => 0.1
                ,'max_count' => 1
                ,'order_method' => null
                ,'is_mandatory' => 1
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            ,
            [
                /* Expired Group */ 
                'episode_id' => 4
                ,'rule_group_id' => '7991CD0B-7061-C5CE-C360-67A3E19D7ED2'
                ,'rule_group_name' => 'Expired Group'
                ,'rule_group_name_slug'=> 'expired group'
                ,'max_multiplier' => 10
                ,'min_multiplier' => 10
                ,'max_modifier' => 100
                ,'min_modifier' => 8
                ,'max_count' => 1
                ,'order_method' => 1
                ,'is_mandatory' => 1
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
            ]
            
    ]
    
    ,'pt_rule' =>  [
            /* A Rule that can be closed */
            
            [  
                'episode_id' => 7
                ,'rule_id' => 'AFF9593-589D-4C7D-6924-82B5EBD4F253'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'Rule That can be Closed'
                ,'rule_name_slug' => 'rule_can_be_closed'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            /* A Rule that Requires A new Version */
            ,[
                
                'episode_id' => 8
                ,'rule_id' => 'FAF37D16-4BC4-C778-09A5-8C59A622A22D'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'Rule That needs a Version'
                ,'rule_name_slug' => 'rule_that_needs_a_version'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            /* A Rule that can be updated */
            ,[
                
                'episode_id' => 9
                ,'rule_id' => '2B84454D-69CC-E95D-4A71-61594FC23B8C'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'Rule That can be Updated'
                ,'rule_name_slug' => 'rule_that_can_be_updated'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            /* A Group that can not be closed */ 
            ,[
                
                'episode_id' => 10
                ,'rule_id' => 'E6731CF5-FC30-9386-AC6C-D3FC1A62A059'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'Not Be Closed'
                ,'rule_name_slug' => 'not_be_closed'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
    ]
    
    ,'pt_rule_sys_zone' => [
        
       [
            'episode_id' => 3
            ,'rule_id' => 'E6731CF5-FC30-9386-AC6C-D3FC1A62A059'
            ,'zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
        ]
        
        
    ]
];