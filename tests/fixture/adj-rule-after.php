<?php 
return [
     
     'pt_rule' => 
        [
            /* A Rule that has been closed */
            
            [  
                'episode_id' => 7
                ,'rule_id' => 'AFF9593-589D-4C7D-6924-82B5EBD4F253'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'Rule That can be Closed'
                ,'rule_name_slug' => 'rule_can_be_closed'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d') 
                
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
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d') 
                
            ]
            
            /* A Rule that can be updated */
            ,[
                
                'episode_id' => 9
                ,'rule_id' => '2B84454D-69CC-E95D-4A71-61594FC23B8C'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'Rule That can be Updated'
                ,'rule_name_slug' => 'rule_that_can_be_updated'
                ,'multiplier' =>null
                ,'modifier' => 67
                ,'invert_flag' => 0
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
            
            /* A New Entity */
            ,[
                
                'episode_id' => 11
                ,'rule_id' => 'AA9C989D-3823-44CF-B74A-E6E3784D2335'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'A New Rule'
                ,'rule_name_slug' => 'a_new_rule'
                ,'multiplier' =>null
                ,'modifier' => 67
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            /* A new version */
             ,[
                
                'episode_id' => 12
                ,'rule_id' => 'FAF37D16-4BC4-C778-09A5-8C59A622A22D'
                ,'rule_group_id' =>'644ACED6-94F8-FF4B-B66E-BB572338AC4B'
                ,'rule_name' => 'A new version'
                ,'rule_name_slug' => 'a_new_version'
                ,'multiplier' => null
                ,'modifier' => 5
                ,'invert_flag' =>0
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
    ]
];