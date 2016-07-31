<?php
return [
         'pt_result_common' => 
        [
             [
                'slot_id' => 1
                ,'system_ep'  => null
                ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'system_zone_ep' => null
                ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
                ,'event_type_ep' => null
                ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' // Donation Event Type
                ,'event_id' => 2
                ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
                ,'rule_chain_ep' => null
                ,'rule_chain_id' => null
            ]     
        ]
        
        ,'pt_result_score' => 
        [
        
            [
                 'slot_id' => 1
                ,'score_ep' => null
                ,'score_qty' => 1
                ,'score_group_ep' => null
                ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA'
                ,'score_group_id' => null
                ,'score_base' =>  null
                ,'score_cal_raw' => null
                ,'score_cal_rounded' => null
                ,'score_cal_capped' => null
            ]
            
            ,[
                 'slot_id' => 2
                ,'score_ep' => null
                ,'score_qty' => 1
                ,'score_group_ep' => null
                ,'score_id'  => '66C19B18-0C52-29A2-09CE-0D9021EDB0CB'
                ,'score_group_id' => null
                ,'score_base' =>  null
                ,'score_cal_raw' => null
                ,'score_cal_rounded' => null
                ,'score_cal_capped' => null
            ]
            
            ,[
                 'slot_id' => 3
                ,'score_ep' => null
                ,'score_qty' => 1
                ,'score_group_ep' => null
                ,'score_id'  => 'EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0'
                ,'score_group_id' => null
                ,'score_base' =>  null
                ,'score_cal_raw' => null
                ,'score_cal_rounded' => null
                ,'score_cal_capped' => null
            ]
    ]
    
    ,'pt_result_rule' => 
    [
       
        [
            'slot_id' => 1   
            ,'rule_ep' => null
            ,'rule_id' =>  '352F04DC-7338-A56F-75F8-29CC51B35EBE'
            ,'rule_group_ep' => null
            ,'rule_group_id' => null
            ,'chain_member_ep' => null
            ,'chain_member_id' => null
            ,'apply_all_score' => 1
            ,'apply_all_sys'  => 1
            ,'apply_all_zone' => 1
            ,'override_modifier'   => null
            ,'override_multiplier' => null
            ,'max_value' => null
        ]
        
        
        ,[
            'slot_id' => 2   
            ,'rule_ep' => null
            ,'rule_id' =>  'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD'
            ,'rule_group_ep' => null
            ,'rule_group_id' => null
            ,'chain_member_ep' => null
            ,'chain_member_id' => null
            ,'apply_all_score' => 1
            ,'apply_all_sys'  => 1
            ,'apply_all_zone' => 1
            ,'override_modifier'   => null
            ,'override_multiplier' => null
            ,'max_value' => null
            
        ]
        
    ]
];