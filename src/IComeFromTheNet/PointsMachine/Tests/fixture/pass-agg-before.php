<?php
return [
    
    
    'pt_result_score' =>
    [
        /* Valid Record */
        [
             'slot_id' => 1
            ,'score_ep' => 1
            ,'score_group_ep' => 1
            ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA' // crystal shard
            ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED' //Enchanting Supplies
            ,'score_base' => 0.5
            ,'score_cal_raw' => null
            ,'score_cal_rounded' => null
            ,'score_cal_capped' => null
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 2
            ,'score_ep' => 4
            ,'score_group_ep' => 2
            ,'score_id'  => 'EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0' // Healing Pot in Alchmey Group
            ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC' // Alchmey supplies
            ,'score_base' =>  0.5
            ,'score_cal_raw' => null
            ,'score_cal_rounded' => null
            ,'score_cal_capped' => null
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 3
            ,'score_ep' => 5
            ,'score_group_ep' => 2
            ,'score_id'  => 'ABC92D3D-4707-44BA-1653-F6A711757169' // Mana Pot in Alchmey Group
            ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC' // Alchmey Supplies
            ,'score_base' =>  0.5
            ,'score_cal_raw' => null
            ,'score_cal_rounded' => null
            ,'score_cal_capped' => null
        ]
        
    ]
    
    ,'pt_result_rule' => 
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
        
        ,[ /* Medium Discount */ 
            'slot_id'  => 2
            ,'rule_ep'=> 3
            ,'rule_id' => '3235B350-593C-7F7C-22BD-6089A36C155B' 
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'chain_member_ep' => 1
            ,'chain_member_id' => '6A650CC9-223E-02A3-2F89-22D650272237'
            ,'apply_all_score' => 0  
            ,'apply_all_sys'  => 0
            ,'apply_all_zone' => 0
            ,'override_modifier' =>   2
            ,'override_multiplier' => 5
            ,'max_value' => 10
        ]
    ]
    
    ,'pt_result_rank' => 
    [
        [
             'score_slot_id'  => 1
            ,'rule_slot_id'    => 1
            ,'rule_ep'        => 2
            ,'rule_id'        => 'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' 
            ,'rule_group_ep'  => 2
            ,'rule_group_id'  => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank_high'      => 1
            ,'rank_low'       => 2
            ,'rule_group_seq' => 1
            ,'max_value'      => 50,
         ]
        
        ,[
             'score_slot_id'  => 1
            ,'rule_slot_id'   => 2
            ,'rule_ep'        => 3
            ,'rule_id'        => '3235B350-593C-7F7C-22BD-6089A36C155B' 
            ,'rule_group_ep'  => 2
            ,'rule_group_id'  => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank_high'      => 2
            ,'rank_low'       => 1
            ,'rule_group_seq' => 1
            ,'max_value'      => 10,
        ]
  
        
        ,[
             'score_slot_id'  => 2
            ,'rule_slot_id'    => 1
            ,'rule_ep'        => 2
            ,'rule_id'        => 'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' 
            ,'rule_group_ep'  => 2
            ,'rule_group_id'  => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank_high'      => 1
            ,'rank_low'       => 2
            ,'rule_group_seq' => 1
            ,'max_value'      => 50,
        ]
        
        ,[
             'score_slot_id'  => 2
            ,'rule_slot_id'   => 2
            ,'rule_ep'        => 3
            ,'rule_id'        => '3235B350-593C-7F7C-22BD-6089A36C155B' 
            ,'rule_group_ep'  => 2
            ,'rule_group_id'  => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank_high'      => 2
            ,'rank_low'       => 1
            ,'rule_group_seq' => 1
            ,'max_value'      => 10,
        ]
        
        
        ,[
             'score_slot_id'  => 3
            ,'rule_slot_id'   => 1
            ,'rule_ep'        => 2
            ,'rule_id'        => 'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' 
            ,'rule_group_ep'  => 2
            ,'rule_group_id'  => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank_high'      => 1
            ,'rank_low'       => 2
            ,'rule_group_seq' => 1
            ,'max_value'      => 50,
        ]
        
  
        ,[
             'score_slot_id'  => 3
            ,'rule_slot_id'   => 2
            ,'rule_ep'        => 3
            ,'rule_id'        => '3235B350-593C-7F7C-22BD-6089A36C155B' 
            ,'rule_group_ep'  => 2
            ,'rule_group_id'  => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank_high'      => 2
            ,'rank_low'       => 1
            ,'rule_group_seq' => 1
            ,'max_value'      => 10,
        ]
  
        
    
    ]
    
];