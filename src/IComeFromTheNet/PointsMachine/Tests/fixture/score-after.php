<?php
return [
    
        'pt_score' => [
            
            /* Non Current Score That can not be updated  (link to a non current score group)*/  
            [
                'episode_id'   => 12
                ,'score_id'     => '6E34457C-BF12-20A0-AEC8-B8FE436CE304'
                ,'score_name' => 'Non Current Score'
                ,'score_name_slug' => 'non_current_score'
                ,'score_value'   => 0.7
                ,'score_group_id' => '62A58FF0-97F7-1D23-A88D-C00D9542FF18'
                ,'enabled_from'    => (new DateTime('now - 8 day'))->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('now -1 day'))->format('Y-m-d')
            ]  
            
            
            /* A New Score */  
            ,[
                 'episode_id'     => 13
                ,'score_id'       => '8333E339-33C9-A58F-88F8-8FF5D3F837F2'
                ,'score_name'     => 'Mock Score'
                ,'score_name_slug'=> 'mock_score'
                ,'score_value'    => 0.2
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from'   => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'     => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]      
            
        ]
        
    ];