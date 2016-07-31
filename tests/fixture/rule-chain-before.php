<?php
return [
    
        'pt_rule_chain' => [
            
            /* None Current Rule Chain that can not be updated (no chain members) */
            [
                'episode_id' => 3
                ,'rule_chain_id'  =>'C4039C0B-FF81-43CE-7CB3-B85EB3802C71'
                ,'event_type_id'  =>'93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'None Current Chain'
                ,'chain_name_slug'  =>'none_current_chain'
                ,'rounding_option' => 3
                ,'cap_value'    => null
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'   =>  (new DateTime('now - 1 day'))->format('Y-m-d') 
            ]   
            
            /* A Current Chain that can be updated without new version */
             
            ,[
                'episode_id' => 4
                ,'rule_chain_id'  =>'C1EA95B8A-C10E-ED88-EE9E-9761F31453D4'
                ,'event_type_id'  =>'93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'Updatable Chain'
                ,'chain_name_slug'  =>'updatable_chain'
                ,'rounding_option' => 3
                ,'cap_value'    => null
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'   =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ] 
        
             /* Chain that requires a new version */    
            ,[
                'episode_id' => 5
                ,'rule_chain_id'  =>'8FE3DACA-7455-0E21-474B-D1B0D694E5C5'
                ,'event_type_id'  =>'93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'new version'
                ,'chain_name_slug'  =>'new_version'
                ,'rounding_option' => 2
                ,'cap_value'    => -5
                ,'enabled_from' => (new DateTime('now -1 day'))->format('Y-m-d')
                ,'enabled_to'   =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ]
            
            /* A Current chain that can be closed */
           ,[
                'episode_id' => 6
                ,'rule_chain_id'  =>'5D3EA054-1D4D-5296-FA5F-30A2BA603755'
                ,'event_type_id'  =>'93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'chain can be closed'
                ,'chain_name_slug'  =>'chain_can_be_closed'
                ,'rounding_option' => 2
                ,'cap_value'    => -5
                ,'enabled_from' => (new DateTime('now -1 day'))->format('Y-m-d')
                ,'enabled_to'   =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ]
        ]
        
       ,'pt_event_type' => 
        [
            /* Non current event type that can not be used in new episode */
            [
                'episode_id' => 3
                ,'event_type_id' => 'D06F2B49-A257-9F09-BFF8-C555D8512D75'
                ,'event_name' => 'Depreciated Event Type'
                ,'event_name_slug' => 'depreciated_event_yype'
                ,'enabled_from' => (new DateTime('now - 1 week'))->format('Y-m-d')
                ,'enabled_to' =>  (new DateTime('now'))->format('Y-m-d')
            ]
            
        ]
        
       , 'pt_system' => 
        [
            /* A Non current system that can not be used in new episodes */
            [
                'episode_id' => 2
                ,'system_id'  => 'F69385AC-329F-5CD4-0E6F-64DAD1714093'
                ,'system_name' => 'Depreciated System'
                ,'system_name_slug' => 'depreciated_system'
                ,'enabled_from' => (new DateTime('now - 2 week'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('now'))->format('Y-m-d')
            ]
        ]
        
    ];