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
        
        ,'pt_score' => 
        [
            
            /* Expired Scores */
            [
                'episode_id'   => 20
                ,'score_id'     => '1CCAAACA-4E67-9D18-8738-8E84A954B4A6'
                ,'score_name' => 'Expired Score A'
                ,'score_name_slug' => 'expired_score_a'
                ,'score_value'   => 0.5
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
            ]    
            , 
            [
                'episode_id'   => 25
                ,'score_id'     => '0FED6645-6FEF-2F28-1016-8C9DD1654E7E'
                ,'score_name' => 'Expired Score B'
                ,'score_name_slug' => 'expired_score_b'
                ,'score_value'   => 0.2
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d')
            ] 
            
        ]
    
    /* Score values in tmp table */    
    
    ,'pt_result_score' => 
    [
        
        /* Valid Record */
        [
             'slot_id' => 1
            ,'score_ep' => null
            ,'score_group_ep' => null
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' => null
            ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA'
            ,'score_group_id' => null
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' // Donation Event Type
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'score_base' =>  null
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 2
            ,'score_ep' => null
            ,'score_group_ep' => null
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' =>  null
            ,'score_id'  => 'EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0' // Healing Pot in Alchmey Group
            ,'score_group_id' => null
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF' 
            ,'system_zone_id' => '' // no zone given
            ,'event_type_id' =>  '93B19460-04F4-85CD-6553-00D7125CFDAE' //Withdrawal Event Type
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'score_base' =>  null
        ]
        
        
        /* This record points to expired system */
        ,[
             'slot_id' => 3
            ,'score_ep' => null
            ,'score_group_ep' => null
            ,'system_ep'  => null
            ,'system_zone_ep' => null
            ,'event_type_ep' =>  null
            ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA'
            ,'score_group_id' => null
            ,'system_id' => 'D9025C02-5084-B3DD-3329-F54F857260FA'
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' 
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'score_base' =>  null
        ]
        
        
        
        /* This record points to expired score */
       
        
        
    ]
];
