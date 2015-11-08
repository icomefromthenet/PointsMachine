<?php
return [
    
    'pt_result_rule' => 
    [
        
        [ /* Big Discount */ 
            'slot_id'  => 1
            ,'rule_ep'=> 2
            ,'rule_id' => 'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' 
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'chain_member_ep' => 1
            ,'chain_member_id' => '6A650CC9-223E-02A3-2F89-22D650272237'
            ,'apply_all_score' => 0  
            ,'apply_all_sys'  => 0
            ,'apply_all_zone' => 0
            ,'override_modifier' =>   5
            ,'override_multiplier' => 10
            ,'max_value' => 50
        ]
        
    ]
    
    ,'pt_result_cjoin'  =>
    [
        [
            'rule_slot_id'  => 1
            ,'score_slot_id' => 1
        ]    
        
        ,[
            'rule_slot_id'  => 1
            ,'score_slot_id' => 2
        ]
        
        ,[
            'rule_slot_id'  => 1
            ,'score_slot_id' => 3
        ]
    ]
    
];