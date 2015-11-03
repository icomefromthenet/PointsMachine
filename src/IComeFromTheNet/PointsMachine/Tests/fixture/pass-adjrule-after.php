<?php
return [
    
    'pt_result_rule' => 
    [
        /* Valid Rule */
        [
            'slot_id' => 1   
            ,'rule_ep' => 2
            ,'rule_id' =>  'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' // Big Discount
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'chain_member_ep' => 3
            ,'chain_member_id' => '3E0CC551-1AC8-402F-84BD-C597FEE3B749'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 1
            
        ]
      
        
        /* Rule not in zone is still included */
        ,[
            'slot_id' => 3  
            ,'rule_ep' => 4
            ,'rule_id' =>  '61C6CA0C-2896-D97E-0A39-673121D4AF52' // Small discount
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'chain_member_ep' => 3
            ,'chain_member_id' => '3E0CC551-1AC8-402F-84BD-C597FEE3B749'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 1
            
        ]
        
         /* Rule links all systems and all groups */
        ,[
            'slot_id' => 5  
            ,'rule_ep' => 8
            ,'rule_id' =>  '2F1577C8-903E-979F-4BAD-4D79313AD445' // links to all rule group and all systems
            ,'rule_group_ep' => 4
            ,'rule_group_id' => 'F777BD13-1991-B950-2405-86138A62129A'
            ,'chain_member_ep' => 4
            ,'chain_member_id' => 'EF785FD1-F0A5-3D1F-746A-6F3B374C71AB'
            ,'apply_all_score' => 1
            ,'apply_all_sys'   => 1
            ,'apply_all_zone'  => 1
            
        ]
    
    
    
    ]
    
    
];