<?php
return [
    
        'pt_score_group' => 
        [
            
            /* Non Current Score Group */
            [
                 'episode_id'       => 5
                ,'score_group_id'  => '62A58FF0-97F7-1D23-A88D-C00D9542FF18'
                ,'group_name'      => 'Non Current'
                ,'group_name_slug' => 'non_current'
                ,'enabled_from'    => (new DateTime('now - 8 day'))->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('now -1 day'))->format('Y-m-d')
                
            ]
        ]
        
        ,'pt_score' => [
            
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
                
            
        ]
        
    ];