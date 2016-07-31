<?php
return [
    
    
    'pt_result_rule' => 
    [
        /* Overrides used */
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
            ,'override_modifier'   => 5
            ,'override_multiplier' => 2
            ,'max_value' => 10    
        ]
      
        /* No Overrides Used */
        
        ,[
            'slot_id' => 2   
            ,'rule_ep' => 2
            ,'rule_id' =>  'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' // Big Discount
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'chain_member_ep' => 3
            ,'chain_member_id' => '3E0CC551-1AC8-402F-84BD-C597FEE3B749'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 1
            ,'override_modifier'   => null
            ,'override_multiplier' => 0.8
            ,'max_value' => 0.8    
        ]
      
       /* Rule with invert flag */
        ,[
            'slot_id' => 3   
            ,'rule_ep' => 7
            ,'rule_id' =>  'D2BD6919-9442-CC2D-ABCE-A7D3A2162258' 
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'chain_member_ep' => 3
            ,'chain_member_id' => '3E0CC551-1AC8-402F-84BD-C597FEE3B749'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 1
            ,'override_modifier'   => null
            ,'override_multiplier' => 0.1
            ,'max_value' => 0.1    
        ]
    
    ]
    
    
];