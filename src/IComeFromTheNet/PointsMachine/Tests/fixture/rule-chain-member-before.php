<?php
return [
    
    'pt_rule_group' => 
    [
        /* Non Current Entity that can not be used in new entity */   
        [
            'episode_id' => 3
            ,'rule_group_id' => 'A94BB0F5-6568-EAF7-E7D9-FAE0D861496B'
            ,'rule_group_name' => 'Non Current Group'
            ,'rule_group_name_slug'=> 'non_current_group'
            ,'max_multiplier' => null
            ,'min_multiplier' => null
            ,'max_modifier' => 5
            ,'min_modifier' => 0.1
            ,'max_count' => 1
            ,'order_method' => null
            ,'is_mandatory' => 1
            ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
            ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
        ]
    ]
    
    ,'pt_rule_chain' =>
    [
        /* Non Current RuleChain */
        [
            'episode_id' => 3
            ,'rule_chain_id'  =>'CDB50A01-F629-4809-2A06-A44813709925'
            ,'event_type_id'  =>'93B19460-04F4-85CD-6553-00D7125CFDAE'
            ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
            ,'chain_name'  =>'non current rule chain'
            ,'chain_name_slug'  =>'non_current_rule_chain'
            ,'rounding_option' => 2
            ,'cap_value'    => -120
            ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
            ,'enabled_to'   =>  (new DateTime('now'))->format('Y-m-d') 
        ] 

    
    ]
    
    ,'pt_chain_member' =>
    [
         /* Non Current Chain */
        [
           'episode_id' => 3
           ,'chain_member_id' =>'11A09C6D-C851-5874-8667-72BE94DD1A47'
           ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' // Donation Event Chain 
           ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // discounts
           ,'order_seq' => 1
           ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
           ,'enabled_to'  =>  (new DateTime('now -1 day'))->format('Y-m-d') 
        ]     
        
        /* A Current Member that can be updated  without new verison*/
        ,[
           'episode_id' => 4
           ,'chain_member_id' =>'DB02441C-EBDC-7C79-AFF9-353402F9DB04'
           ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' // Donation Event Chain 
           ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // discounts
           ,'order_seq' => 2
           ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
           ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')     
        ]
        
        /* A Current Member that requires a new version */
        ,[
           'episode_id' => 5
           ,'chain_member_id' =>'1D7A2FC4-E1F0-5BCE-F2AB-93AF302BCEFA'
           ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' // Donation Event Chain 
           ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // discounts
           ,'order_seq' => 2
           ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
           ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')     
        ]
        
        /* A Current Member that will be closed */
        ,[
            'episode_id' => 6
           ,'chain_member_id' =>'824DF964-D106-5704-58CD-86E51620B803'
           ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' // Donation Event Chain 
           ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // discounts
           ,'order_seq' => 2
           ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
           ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')     
        ]
        
        
    ]
    
     
];