<?php
return [
      
    /* Score values in tmp table */    
    
    'pt_result_score' => 
    [
        
        /* Valid Record */
        [
             'slot_id' => 1
            ,'score_ep' => 1
            ,'score_group_ep' => 1
            ,'system_ep'  => 1
            ,'system_zone_ep' => 1
            ,'event_type_ep' => 1
            ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA'
            ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733'
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'score_base' => 0.5
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 2
            ,'score_ep' => 4
            ,'score_group_ep' => 2
            ,'system_ep'  => 1
            ,'system_zone_ep' => null
            ,'event_type_ep' => 2
            ,'score_id'  => 'EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0' // Healing Pot in Alchmey Group
            ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF' 
            ,'system_zone_id' => '' // no zone given
            ,'event_type_id' =>  '93B19460-04F4-85CD-6553-00D7125CFDAE' //Withdrawal Event Type
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            ,'score_base' =>  0.5
        ]
        
        /* Invalid Groups should not be in this table anymore */
        
    ]
];
