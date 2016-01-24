<?php
return [
    
    'pt_rule_chain' => [
     
        /* A current chain */
        [
            'episode_id' => 3
            ,'rule_chain_id'  =>'40C2AB6A-479D-4B9A-8383-3F4B7ED35B83'
            ,'event_type_id'  =>'55A33394-E759-611A-3015-A17B86469B5D' //current type defined below
            ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
            ,'chain_name'  =>'Current Chain'
            ,'chain_name_slug'  =>'current_chain'
            ,'rounding_option' => 2
            ,'cap_value'    => -120
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to'   =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
        ]

    ]
    
    
    ,'pt_event_type' => [ 
        
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
            ,'event_name' => 'Updatable Type'
            ,'event_name_slug' => 'updatable_type'
            ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ]  
        
        /* A Current type that requires a new version  */
        ,[
            'episode_id' => 5
            ,'event_type_id' => '83348551-9A81-C9B8-61B8-654DD25D5907'
            ,'event_name' => 'New Version Type'
            ,'event_name_slug' => 'new_version_type'
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ] 
        
        /* A Current type that can be closed */
        ,[
            'episode_id' => 6
            ,'event_type_id' => '1210A00C-4EB7-9042-F19E-38E865B4E01'
            ,'event_name' => 'Can be closed'
            ,'event_name_slug' => 'can_be_closed'
            ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
            ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
        ] 
        
    ]
    
    
    
    
 ];