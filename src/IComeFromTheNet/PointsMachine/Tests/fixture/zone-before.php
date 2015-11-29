<?php
return [
        'pt_system' => 
        [
            /* Inactive system that not be allowed a zone to be linked on */
            [
                'episode_id' => 2
                ,'system_id'  => '583D9777-AA78-47EC-BCB6-EB60471B2C32'
                ,'system_name' => 'Inactive System'
                ,'system_name_slug' => 'inactive_system'
                ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('now'))->format('Y-m-d')
            ]
            
           
        ]
        
        ,'pt_system_zone' => 
        [
               
            /* A Zone with no rule relations. */   
            [
               'episode_id' => 5
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '68902DCF-EFBA-9C53-DD28-A26F667C5786'
               ,'zone_name' => 'No Relations Zone'
               ,'zone_name_slug' => 'no_relations_zone'
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ]  
            
            /* Zone that can be updated  */   
            ,[
               'episode_id' => 6
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '663CC8C6-5E5C-D59A-3580-BA949E7ABB27'
               ,'zone_name' => 'Updateable Zone'
               ,'zone_name_slug' => 'updateable_zone'
               ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ]  
            
            
             /* Zone that requires a new version  */   
            ,[
               'episode_id' => 7
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '146CD46A-A14A-AD02-9A69-FBF7AC302A81'
               ,'zone_name' => 'New Version Required on Update'
               ,'zone_name_slug' => 'new_version_required_on_update'
               ,'enabled_from' => (new DateTime('now - 7 day'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ] 
            
            
        ]
        
];
