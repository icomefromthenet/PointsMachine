<?php
return [
    
    
    
    'pt_chain_member' =>
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
           ,'order_seq' => 7
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
           ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')     
        ]
        
        /* A Current Member that will be closed */
         ,[
            'episode_id' => 6
           ,'chain_member_id' =>'824DF964-D106-5704-58CD-86E51620B803'
           ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' // Donation Event Chain 
           ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // discounts
           ,'order_seq' => 2
           ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
           ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')     
        ]
        
        /* A New Rule Chain */
        ,[
            'episode_id' => 7
           ,'chain_member_id' =>'98E570E7-A497-8236-58A6-0F8EB2C2939B'
           ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' // Donation Event Chain 
           ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // discounts
           ,'order_seq' => 2
           ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
           ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')     
        ]
        
         /* A new version of episode 5 */
         ,[
           'episode_id' => 8
           ,'chain_member_id' =>'1D7A2FC4-E1F0-5BCE-F2AB-93AF302BCEFA'
           ,'rule_chain_id' =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' // Donation Event Chain 
           ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' // discounts
           ,'order_seq' => 8
           ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
           ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')     
        ]
        
    ]
   
     
];