<?php
return [
    
     'pt_result_common' => 
    [
        
        /* Valid Record */
        [
             'slot_id' => 1
            ,'system_ep'  => 1
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
    
            ,'system_zone_ep' => 1
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            
            ,'event_type_ep' => 1
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' // Donation Event Type
        
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            
            ,'rule_chain_ep' => 1
            ,'rule_chain_id' => '6A650CC9-223E-02A3-2F89-22D650272237' //Withdrawal Chain
        
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
  
    
    ,'pt_transaction_header' => [
        
        [
            'event_id'           => 1
            ,'system_ep'         => 1
            ,'zone_ep'           => 1
            ,'event_type_ep'     => 1
            ,'created_date'      => (new DateTime('now'))->format('Y-m-d')
            ,'processing_date'   => (new DateTime('now'))->format('Y-m-d')
            ,'occured_date'      => (new DateTime('now'))->format('Y-m-d')
            ,'calrunvalue'       => 134.56
            ,'calrunvalue_round' => 0    
        ]
        
    ] 
];