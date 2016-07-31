<?php
return [
        'pt_system' => 
        [
            [
                'episode_id' => 2
                ,'system_id'  => 'D9025C02-5084-B3DD-3329-F54F857260FA'
                ,'system_name' => 'Expired System A'
                ,'system_name_slug' => 'expired_system_a'
                ,'enabled_from' => (new DateTime('now - 5 days'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('now'))->format('Y-m-d')
            ]
        ]
       
        
        ,'pt_event_type' => 
        [
            /* Expired Event Type */
            [
                'episode_id' => 3
                ,'event_type_id' => '3DF73708-CE68-C20E-F831-A8C0013F0241'
                ,'event_name' => 'Expired Event Type A'
                ,'event_name_slug' => 'expired_event_type_a'
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
            ]
          
        ]
         ,'pt_rule_chain' =>
        [
            /* Expired Chain using Withdrawal Chain */
            [
                'episode_id' => 3
                ,'rule_chain_id'  =>'6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE'
                ,'event_type_id'  =>'93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'Expired Withdrawal Chain A'
                ,'chain_name_slug'  =>'expired_withdrawal_chain_a'
                ,'rounding_option' => 0
                ,'cap_value'    => null
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
            ]
            
            /* Chain For expired event tyle */
            ,[
                'episode_id' => 4
                ,'rule_chain_id'  =>'D9613721-D057-34F1-FD05-D4A196ACECE6'
                ,'event_type_id'  =>'3DF73708-CE68-C20E-F831-A8C0013F0241'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'Expired Chain B'
                ,'chain_name_slug'  =>'expired_chain_b'
                ,'rounding_option' => 0
                ,'cap_value'    => null
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'   =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ]
            
        ]
    
    /* Score values in tmp table */    
    
    ,'pt_result_common' => 
    [
        
        /* Valid Record */
        [
             'slot_id' => 1
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' => null
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' // Donation Event Type
            ,'event_id' => 1
            ,'rule_chain_ep' => null
            ,'rule_chain_id' => null
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 2
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' =>  null
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF' 
            ,'system_zone_id' => '' // no zone given
            ,'event_type_id' =>  '93B19460-04F4-85CD-6553-00D7125CFDAE' //Withdrawal Event Type
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'rule_chain_ep' => null
            ,'rule_chain_id' => null
        ]
        
        
        /* This record points to expired system */
        ,[
             'slot_id' => 3
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' =>  null
            ,'system_id' => 'D9025C02-5084-B3DD-3329-F54F857260FA'
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' 
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'rule_chain_ep' => null
            ,'rule_chain_id' => null
        ]
        
        
        
         /* Expired Event Type */
        ,[
             'slot_id' => 4
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' => null
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            ,'event_type_id' =>  '3DF73708-CE68-C20E-F831-A8C0013F0241' // Expired Event Type
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'rule_chain_ep' => null
            ,'rule_chain_id' => null
        ]
        
         /* Expired Chain Type */
        ,[
             'slot_id' => 5
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' => null
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
            ,'system_zone_id' => null
            ,'event_type_id' =>  '3DF73708-CE68-C20E-F831-A8C0013F0241' // Donation Event Type
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'rule_chain_ep' => null
            ,'rule_chain_id' => null
        ]
        
    ]
];
