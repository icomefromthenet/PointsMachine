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
            
            /* A Current Episode that can be updated */  
            ,[
                'episode_id'   => 13
                ,'score_id'     => 'BEA50E4D-0FCF-D858-62C0-2BCBB32FB746'
                ,'score_name'     => 'Update Score'
                ,'score_name_slug' => 'update_score'
                ,'score_value'    => 0.7
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from'    => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
                
            /* Current Score that requires a new version */
            ,[
                'episode_id'      => 14
                ,'score_id'       => '000439C2-3A34-DAB8-C7AB-852CA6EC98D8'
                ,'score_name'     => 'Current Score'
                ,'score_name_slug' => 'current_score'
                ,'score_value'     => 0.7
                ,'score_group_id'  => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from'    => (new DateTime('now - 1 day'))->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
              
            /* A Current Episode that can be closed */  
            ,[
                'episode_id'   => 15
                ,'score_id'     => '58AEFC40-C976-70E4-9F92-134DAFDB86E9'
                ,'score_name'     => 'Closed Score'
                ,'score_name_slug' => 'Close Score'
                ,'score_value'    => 0.7
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from'    => (new DateTime('now - 1 day'))->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
        ]
        
    ];