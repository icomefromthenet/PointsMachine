<?php
return [
      
    /* Score values in tmp table */    
    
    'pt_result_score' => 
    [
        
        /* Valid Record */
        [
             'slot_id' => 1
            ,'score_ep' => 1
            ,'score_qty' => 1
            ,'score_group_ep' => 1
            ,'score_id'  => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA'
            ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
            ,'score_base' => 0.5
            ,'score_cal_raw' => null
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
            ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
            ,'score_base' =>  0.5
            ,'score_cal_raw' => null
            ,'score_cal_rounded' => null
            ,'score_cal_capped' => null
        
        ]
        
        /* Invalid Groups should not be in this table anymore */
        
    ]
];
