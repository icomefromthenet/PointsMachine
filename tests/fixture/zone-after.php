<?php
return [
        
        
        'pt_system_zone' => 
        [
            /* A Zone with no rule relations. */   
            [
               'episode_id' => 5
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '68902DCF-EFBA-9C53-DD28-A26F667C5786'
               ,'zone_name' => 'No Relations Zone'
               ,'zone_name_slug' => 'no_relations_zone'
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to' => (new DateTime('now'))->format('Y-m-d')
            
            ]          
                 
            
            /* Zone that can be updated  */   
            ,[
               'episode_id' => 6
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '663CC8C6-5E5C-D59A-3580-BA949E7ABB27'
               ,'zone_name' => 'Updateable Zone Changed'
               ,'zone_name_slug' => 'updateable_zone_changed'
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
               ,'enabled_to' => (new DateTime('now'))->format('Y-m-d')
            
            ] 
            
            
              
             /* A Zone with no rule relations. */   
            ,[
               'episode_id' => 8
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '89BF34B3-599F-5A57-C07F-8F08CA9F4845'
               ,'zone_name' => 'Mock Zone'
               ,'zone_name_slug' => 'mock_zone'
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ]   
            
             /* New Version Created from zone at episode 7*/   
            ,[
               'episode_id' => 9
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '146CD46A-A14A-AD02-9A69-FBF7AC302A81'
               ,'zone_name' => 'New Version Created'
               ,'zone_name_slug' => 'new_version_created'
               ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ] 
            
            
        ]
        
];
