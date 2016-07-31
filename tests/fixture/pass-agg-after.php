<?php
return [
    /* Testing the Min modifier value from the group is used and that if both max and min values are set same value
       that not cause error (testing on the multipler with both max and min set to 10)
    */
    
    'pt_result_agg' => 
    [
        [
            'score_slot_id' => 1
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank' => 1
            ,'modifier' => 8
            ,'multiplier' => 10
            ,'cumval' => 13 // 0.5 * 10 +8
        ]    
        
        
       , [
            'score_slot_id' => 2
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank' => 1
            ,'modifier' => 8
            ,'multiplier' => 10
            ,'cumval' => 13 // 0.5 * 10 +8
        ]
        
        ,[
            'score_slot_id' => 3
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rank' => 1
            ,'modifier' => 8
            ,'multiplier' => 10
            ,'cumval' => 13 // 0.5 * 10 +8
        ]
        
        
    ]
    
    ,'pt_result_score' =>
    [
        /* Valid Record */
        [
             'slot_id' => 1
            ,'score_ep' => 1
            ,'score_qty' => 1
            ,'score_group_ep' => 1
            ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA' // crystal shard
            ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED' //Enchanting Supplies
            ,'score_base' => 0.5
            ,'score_cal_raw' => 13
            ,'score_cal_rounded' => null
            ,'score_cal_capped' => null
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 2
            ,'score_ep' => 4
            ,'score_qty' => 1
            ,'score_group_ep' => 2
            ,'score_id'  => 'EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0' // Healing Pot in Alchmey Group
            ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC' // Alchmey supplies
            ,'score_base' =>  0.5
            ,'score_cal_raw' => 13
            ,'score_cal_rounded' => null
            ,'score_cal_capped' => null
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 3
            ,'score_ep' => 5
            ,'score_qty' => 1
            ,'score_group_ep' => 2
            ,'score_id'  => 'ABC92D3D-4707-44BA-1653-F6A711757169' // Mana Pot in Alchmey Group
            ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC' // Alchmey Supplies
            ,'score_base' =>  0.5
            ,'score_cal_raw' => 13
            ,'score_cal_rounded' => null
            ,'score_cal_capped' => null
        ]
        
    ]
    
];