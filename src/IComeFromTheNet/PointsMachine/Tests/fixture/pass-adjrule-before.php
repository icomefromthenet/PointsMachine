<?php
return [
      'pt_rule_group' =>
        [
            [
                /* Expired Group */ 
                'episode_id' => 3
                ,'rule_group_id' => 'D19258EA-F6A1-9719-B98A-C7FE4DF2647A'
                ,'rule_group_name' => 'Expired Group'
                ,'rule_group_name_slug'=> 'expired_group'
                ,'max_multiplier' => null
                ,'min_multiplier' => null
                ,'max_modifier' => null
                ,'min_modifier' => null
                ,'max_count' => 1
                ,'order_method' => null
                ,'is_mandatory' => 1
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
            ]
            
            ,[
                /* Apply to all score and all systems */ 
                'episode_id' => 4
                ,'rule_group_id' => 'F777BD13-1991-B950-2405-86138A62129A'
                ,'rule_group_name' => 'All Sys and Score Groups'
                ,'rule_group_name_slug'=> 'all_sys_and_score_groups'
                ,'max_multiplier' => null
                ,'min_multiplier' => null
                ,'max_modifier' => null
                ,'min_modifier' => null
                ,'max_count' => 1
                ,'order_method' => null
                ,'is_mandatory' => 1
                ,'enabled_from' => (new DateTime(''))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
        
        ]
      
     
     
     ,'pt_rule' => 
        [
    
            [ /* Rule points to expired group, really should not happend if domain model used but could happen
                if manual insert are used.
                I added a query to clear them so need to test it
                */
                 'episode_id' => 7
                ,'rule_id' => '69095838-68B6-6A75-8117-890AC26F04FF'
                ,'rule_group_id' =>'D19258EA-F6A1-9719-B98A-C7FE4DF2647A' //expired group
                ,'rule_name' => 'Rule Points Expired Group'
                ,'rule_name_slug' => 'rule_points_expired_group'
                ,'multiplier' => 0.9
                ,'modifier' => null
                ,'invert_flag' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
                
            ]
            
            ,[ /* valid rule for the all group created upove
                */
                 'episode_id' => 8
                ,'rule_id' => '2F1577C8-903E-979F-4BAD-4D79313AD445'
                ,'rule_group_id' =>'F777BD13-1991-B950-2405-86138A62129A' //all group
                ,'rule_name' => 'Valid Rule'
                ,'rule_name_slug' => 'valid_rule'
                ,'multiplier' => 0.7
                ,'modifier' => null
                ,'invert_flag' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
                
            ]
    
    ]
    
    ,'pt_chain_member' =>
        [
            /* Donation Event Chain */
            [
               /* Discounts Group linked to the donation event chain */
               'episode_id' => 3
               ,'chain_member_id' =>'3E0CC551-1AC8-402F-84BD-C597FEE3B749'
               ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5'
               ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
               ,'order_seq' => 1
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
               
            ]
           
            ,[
               /* Links All Rule Group linked to the donation event chain */
               'episode_id' => 4
               ,'chain_member_id' =>'EF785FD1-F0A5-3D1F-746A-6F3B374C71AB'
               ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5'
               ,'rule_group_id' =>'F777BD13-1991-B950-2405-86138A62129A' //all group
               ,'order_seq' => 2
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
               
            ]
            
    ]
    
    ,'pt_result_common' => 
    [
        /* Valid Record */
        [
             'slot_id' => 1
            ,'system_ep'  => 1
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
    
            ,'system_zone_ep' => 1
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            
            ,'event_type_ep' => 1
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' //Donation Event Type
        
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            
            ,'rule_chain_ep' => 2
            ,'rule_chain_id' => '78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' //Donation Chain
        
        ]
        
    ]
    
    ,'pt_result_rule' => 
    [
        /* Valid Rule */
        [
            'slot_id' => 1   
            ,'rule_ep' => null
            ,'rule_id' =>  'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' // Big Discount
            ,'rule_group_ep' => null
            ,'rule_group_id' => null
            ,'chain_member_ep' => null
            ,'chain_member_id' => null
            ,'override_modifier'   => null
            ,'override_multiplier' => null
        
            
        ]
        
        /* Rule not exist */
        ,[
            'slot_id' => 2  
            ,'rule_ep' => null
            ,'rule_id' =>  'D39CDDFB-09DF-00F1-ED5B-' // Rule not exist
            ,'rule_group_ep' => null
            ,'rule_group_id' => null
            ,'chain_member_ep' => null
            ,'chain_member_id' => null
            ,'override_modifier'   => null
            ,'override_multiplier' => null
        
            
        ]
        
        /* Rule not in zone is still included */
        ,[
            'slot_id' => 3  
            ,'rule_ep' => null
            ,'rule_id' =>  '61C6CA0C-2896-D97E-0A39-673121D4AF52' // Small discount
            ,'rule_group_ep' => null
            ,'rule_group_id' => null
            ,'chain_member_ep' => null
            ,'chain_member_id' => null
            ,'override_modifier'   => null
            ,'override_multiplier' => null
        
            
        ]
        
         /* Rule has Expired Group */
        ,[
            'slot_id' => 4  
            ,'rule_ep' => null
            ,'rule_id' =>  '69095838-68B6-6A75-8117-890AC26F04FF' // Expired Group
            ,'rule_group_ep' => null
            ,'rule_group_id' => null
            ,'chain_member_ep' => null
            ,'chain_member_id' => null
            ,'override_modifier'   => null
            ,'override_multiplier' => null
        
            
        ]
        
         /* Rule links all systems and all groups */
        ,[
            'slot_id' => 5  
            ,'rule_ep' => null
            ,'rule_id' =>  '2F1577C8-903E-979F-4BAD-4D79313AD445' // links to all rule group and all systems
            ,'rule_group_ep' => null
            ,'rule_group_id' => null
            ,'chain_member_ep' => null
            ,'chain_member_id' => null
            ,'override_modifier'   => null
            ,'override_multiplier' => null
        
            
        ]
    ]
    

];