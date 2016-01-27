<?php
return [

  'pt_rule_group' => [
  
        /* A Group that is closed  */
        [
            'episode_id' => 3
            ,'rule_group_id' => '1A44C9FC-B7FA-0EFE-4F1D-7952A6BA7A60'
            ,'rule_group_name' => 'Can be closed'
            ,'rule_group_name_slug'=> 'can_be_closed'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 5
            ,'min_modifier' => 0.1
            ,'max_count' => 1
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
        ]
        
        /* A Current group that  been updated  */
        ,[
            'episode_id' => 4
            ,'rule_group_id' => '634539B7-AB03-2DF7-67D6-2A7A5AF0BDF3'
            ,'rule_group_name' => 'Is Updated'
            ,'rule_group_name_slug'=> 'is_updated'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 5
            ,'min_modifier' => 0.1
            ,'max_count' => 1
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
         /* A Group that been closed and a new version created  */
        
        ,[
            'episode_id' => 5
            ,'rule_group_id' => 'EF82C808-2F84-62C3-1534-E5AFDF7DCDCB'
            ,'rule_group_name' => 'Requires New Version'
            ,'rule_group_name_slug'=> 'requires_new_version'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 5
            ,'min_modifier' => 0.1
            ,'max_count' => 1
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
        ]
        
        /* A New Group  */
        
        ,[
            'episode_id' => 6
            ,'rule_group_id' => 'BFB63A44-5FB4-BA2F-EF52-CDC9634E21A0'
            ,'rule_group_name' => 'A New Group'
            ,'rule_group_name_slug'=> 'a_new_group'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 5
            ,'min_modifier' => 0.1
            ,'max_count' => 1
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
        /* New Version of group */
        
        ,[
            'episode_id' => 7
            ,'rule_group_id' => 'EF82C808-2F84-62C3-1534-E5AFDF7DCDCB'
            ,'rule_group_name' => 'Is New Version'
            ,'rule_group_name_slug'=> 'is_new_version'
            ,'max_multiplier' => 200
            ,'min_multiplier' => 100
            ,'max_modifier' => 5
            ,'min_modifier' => 0.1
            ,'max_count' => 1
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
            
    ]
    
];