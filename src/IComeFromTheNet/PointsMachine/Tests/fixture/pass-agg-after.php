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
    
];