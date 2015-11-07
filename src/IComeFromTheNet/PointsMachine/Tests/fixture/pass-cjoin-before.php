<?php
return [
    'pt_event' => 
    [
        /* Withdrawal Event */
        [
             'event_id'     =>  2
            ,'event_type_id' => '93B19460-04F4-85CD-6553-00D7125CFDAE' //withdrawal event
            ,'process_date' => (new DateTime())->format('Y-m-d')
            ,'occured_date' => (new DateTime())->format('Y-m-d')
            
        ]        
    ]
    
    ,'pt_rule_group' => 
    [
        [
            /* Group With Linked to a single product group
               any rules in this group should be removed 
             */ 
            'episode_id' => 3
            ,'rule_group_id' => '6AF3C1A8-E3F0-E435-5C0D-8939A82D7AFD'
            ,'rule_group_name' => 'Empty Group'
            ,'rule_group_name_slug'=> 'empty_group'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => null
            ,'min_modifier' => null
            ,'max_count' => 1
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
    ]
    
    ,'pt_rule_group_limits' =>
    [
        [
            /* Link to System */
            'episode_id' => 11
            ,'rule_group_id' => '6AF3C1A8-E3F0-E435-5C0D-8939A82D7AFD'
            ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED' // enchanting supplies
            ,'system_id' => null
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')  
        ]
  
    ]  
      
    ,'pt_rule' => 
    [
        /* Empty Rule for Empty Group */
        [  
            'episode_id' => 7
            ,'rule_id' => '9CBFD303-9F44-7891-5DF7-EA7D100A4167'
            ,'rule_group_id' =>'6AF3C1A8-E3F0-E435-5C0D-8939A82D7AFD'
            ,'rule_name' => 'empty rule'
            ,'rule_name_slug' => 'empty rule'
            ,'multiplier' =>1
            ,'modifier' => null
            ,'invert_flag' =>1
            ,'enabled_from' => (new DateTime())->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            
        ]
    ]    
    
    ,'pt_chain_member' =>
    [
        /* Withdrawal Event Chain */
        [
           /* Empty Rule Group */
           'episode_id'         => 3
           ,'chain_member_id'   =>'5B210834-39DF-6A5C-C53B-141ED87557DC'
           ,'rule_chain_id'     =>'6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE'
           ,'rule_group_id'     =>'6AF3C1A8-E3F0-E435-5C0D-8939A82D7AFD'
           ,'order_seq'         => 3
           ,'enabled_from'      => (new DateTime())->format('Y-m-d')
           ,'enabled_to'        =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
           
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
            ,'event_type_id' =>  '93B19460-04F4-85CD-6553-00D7125CFDAE' // Withdrawal event 
        
            ,'event_id' => 2
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            
            ,'rule_chain_ep' => 1
            ,'rule_chain_id' => '6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE' //Withdrawal Chain
        
        ]    

    ]
    
      
    ,'pt_result_score' =>
    [
        /* Enchaning Score Group  */
        [
             'slot_id' => 1
            ,'score_ep' => 1
            ,'score_group_ep' => 1
            ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA' // crystal shard
            ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED' // Enchanting score group
            ,'score_base' => 0.5
        ]
        
        /* Alchmey Score Group  */
        ,[
             'slot_id' => 2
            ,'score_ep' => 4
            ,'score_group_ep' => 2
            ,'score_id'  => 'EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0' // healing pot score
            ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC' // alchmey score group
            ,'score_base' => 0.5
        ]
       
        
    ]
    
    ,'pt_result_rule' => 
    [
       
       /* Discount Adj Group Rules */
       [
            /* Big Discount */ 
            'slot_id' => 1   
            ,'rule_ep' => 2
            ,'rule_id' =>  'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD' // Big Discount Rule
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // Discounts Score Rule Group
            ,'chain_member_ep' => 1
            ,'chain_member_id' => '6A650CC9-223E-02A3-2F89-22D650272237'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 1
            ,'override_modifier'   => null
            ,'override_multiplier' => null
            
        ]
        ,[
            /* Healer Discount */
            'slot_id' => 2
            ,'rule_ep' => 5
            ,'rule_id' =>  'EAF03EED-16AC-557E-6267-7F54ADD83197' // Healer Discount
            ,'rule_group_ep' => 2
            ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD' //  Discounts Rule Group
            ,'chain_member_ep' => 1
            ,'chain_member_id' => '6A650CC9-223E-02A3-2F89-22D650272237'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 0
            ,'override_modifier'   => null
            ,'override_multiplier' => null
            
        ]
       
       /* Withdrwal Conversion Adj Group Rules */
        ,[
            'slot_id' => 3   
            ,'rule_ep' => 1
            ,'rule_id' =>  '352F04DC-7338-A56F-75F8-29CC51B35EBE' // Convert to Negative Rule
            ,'rule_group_ep' => 1
            ,'rule_group_id' => '5515F1B4-A824-30BD-0971-049495BCDB22' // Withdrawal Converstion Rule Group
            ,'chain_member_ep' => 2
            ,'chain_member_id' => '6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 1
            ,'override_modifier'   => null
            ,'override_multiplier' => null
            
        ] 
        
        /* Only Apply to Scores that in groups in alchmey */
        ,[
            'slot_id' => 4 
            ,'rule_ep' => 1
            ,'rule_id' =>  '9CBFD303-9F44-7891-5DF7-EA7D100A4167' // Empty Rule
            ,'rule_group_ep' => 1
            ,'rule_group_id' => '6AF3C1A8-E3F0-E435-5C0D-8939A82D7AFD' // Empty Rule Group
            ,'chain_member_ep' => 3
            ,'chain_member_id' => '5B210834-39DF-6A5C-C53B-141ED87557DC'
            ,'apply_all_score' => 0
            ,'apply_all_sys'   => 0
            ,'apply_all_zone'  => 1
            ,'override_modifier'   => null
            ,'override_multiplier' => null
            
        ] 
    ]
];