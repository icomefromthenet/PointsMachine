<?php
return [
     'pt_system_zone' => [
            [
               'episode_id' => 5
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '5E02B643-1352-C3D9-FB16-C9B9BB0C88C0'
               ,'zone_name' => 'Example Zone'
               ,'zone_name_slug' => 'example_zone'
               ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]    
            
            ,[
               'episode_id' => 6
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => 'FD2A59FA-F264-6DC7-D405-A7FF73461344'
               ,'zone_name' => '2nd Example Zone'
               ,'zone_name_slug' => '2nd_example_zone'
               ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]   
            
             ,[
               'episode_id' => 7
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '532CE54F-13F4-3E88-3F31-8F41EE3E6E3A'
               ,'zone_name' => '3rd Example Zone'
               ,'zone_name_slug' => '3rd_example_zone'
               ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]   
            
            ,[
               'episode_id' => 8
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '65E04897-6F62-3A89-A2F6-675C7105549A'
               ,'zone_name' => '4th Example Zone'
               ,'zone_name_slug' => '4th_example_zone'
               ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]  
            
            ,[
               'episode_id' => 9
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '7B42156E-2FC3-26C8-A3B9-9A15BD8AA66E'
               ,'zone_name' => '5th Example Zone'
               ,'zone_name_slug' => '5th_example_zone'
               ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]  
            
            ,[
               'episode_id' => 10
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '2ECC840F-806A-C0F0-552D-E450F582A5D1'
               ,'zone_name' => 'Expired Zone'
               ,'zone_name_slug' => 'expired zone'
               ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('now'))->format('Y-m-d')
            ]  
            
    ]
    
    ,'pt_rule' => [
        
            
            [  
                'episode_id' => 7
                ,'rule_id' => 'CBEB772F-6E96-5A83-0F24-9F9B363ED240'
                ,'rule_group_id' =>'5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'rule_name' => 'Example Rule'
                ,'rule_name_slug' => 'example_rule'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
             
            ,[  
                'episode_id' => 8
                ,'rule_id' => 'AD5B6D76-A0F5-4688-CE81-835F901CB725'
                ,'rule_group_id' =>'5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'rule_name' => 'Example Rule 2'
                ,'rule_name_slug' => 'example_rule_2'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
             ,[  
                'episode_id' => 9
                ,'rule_id' => '02B7B97C-22B8-E2D1-AE53-9D72F7E9473D'
                ,'rule_group_id' =>'5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'rule_name' => 'Expired Rule'
                ,'rule_name_slug' => 'expired_rule'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d') 
                
            ]
            
    ]
    
    
    ,'pt_rule_sys_zone' => [
        
        /* A Relation that can be closed */
        [
                'episode_id' => 3
                ,'rule_id' => 'CBEB772F-6E96-5A83-0F24-9F9B363ED240'  // example rule
                ,'zone_id' => '5E02B643-1352-C3D9-FB16-C9B9BB0C88C0' //example zone 
                ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
        ]
        
        /* A Relation that can be updated */
        ,[
                'episode_id' => 4
                ,'rule_id' => 'CBEB772F-6E96-5A83-0F24-9F9B363ED240'  // example rule
                ,'zone_id' => 'FD2A59FA-F264-6DC7-D405-A7FF73461344' // 2nd example zone 
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
        ]
        
        
    ]
    
];