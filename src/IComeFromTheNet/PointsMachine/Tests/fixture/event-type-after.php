<?php
return [
    
    'pt_event_type' => [ 
        
         /* A Current Event Type that can not be removed */
        [
            'episode_id' => 3
            ,'event_type_id' => '55A33394-E759-611A-3015-A17B86469B5D'
            ,'event_name' => 'Current Type'
            ,'event_name_slug' => 'current_type'
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]   
        
        /* A current type that can be updated without new version */
        ,[
            'episode_id' => 4
            ,'event_type_id' => '4C7DD3D9-420B-CDD4-5D47-D99A325BDBF6'
            ,'event_name' => 'Updated Type'
            ,'event_name_slug' => 'updated_type'
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]  
        
        /* A Non Current type  */
        ,[
            'episode_id' => 5
            ,'event_type_id' => '83348551-9A81-C9B8-61B8-654DD25D5907'
            ,'event_name' => 'New Version Type'
            ,'event_name_slug' => 'new_version_type'
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('now'))->format('Y-m-d')
        ] 
        
        /* A Current type that can be closed */
        ,[
            'episode_id' => 6
            ,'event_type_id' => '1210A00C-4EB7-9042-F19E-38E865B4E01'
            ,'event_name' => 'Can be closed'
            ,'event_name_slug' => 'can_be_closed'
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('now'))->format('Y-m-d')
        ] 
        /* A New Type */
        ,[
            'episode_id' => 7
            ,'event_type_id' => 'B1A77C7D-F0A6-E2F5-5297-30E3CFC758D1'
            ,'event_name' => 'New Type'
            ,'event_name_slug' => 'new_type'
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ] 
        
        /* A new version Current Type  */
        ,[
            'episode_id' => 8
            ,'event_type_id' => '83348551-9A81-C9B8-61B8-654DD25D5907'
            ,'event_name' => 'New Version'
            ,'event_name_slug' => 'new_version'
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]
        
    ]
    
    
    
 ];