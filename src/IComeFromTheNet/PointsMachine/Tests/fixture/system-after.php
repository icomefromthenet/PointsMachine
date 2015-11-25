<?php
return [
        'pt_system' => 
        [
             /* No relations linked here */
            [
                'episode_id' => 2
                ,'system_id'  => '583D9777-AA78-47EC-BCB6-EB60471B2C32'
                ,'system_name' => 'Test Donations System'
                ,'system_name_slug' => 'test_donations_system'
                ,'enabled_from' => (new DateTime('today - 7 day'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('now'))->format('Y-m-d')
            ]
            
            /* Entity with enabled date of now any changes not cause a new version*/
            ,[
                'episode_id' => 3
                ,'system_id'  => '5CC68937-12BF-C9B9-97E0-3745649101F4'
                ,'system_name' => 'Existing Episode Updated'
                ,'system_name_slug' => 'existing_episode_updated'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
            /* Existing Entity closed by an update */
            ,[
                'episode_id' => 4
                ,'system_id'  => '6663DE9B-9076-3670-C50A-94EE64016AB6'
                ,'system_name' => 'Require New Episode'
                ,'system_name_slug' => 'require_new_episode'
                ,'enabled_from' => (new DateTime('now - 10 day'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('now'))->format('Y-m-d')
            ]
         
            
             /* New Entity that was created during test */
            ,[
                'episode_id' => 5
                ,'system_id'  => '1E8659DA-127C-BE67-6DF5-EB6554AD4B0'
                ,'system_name' => 'Mock System'
                ,'system_name_slug' => 'mock_system'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
           
            /* New Episode Created on Update (SEE entity episode 4) */
            ,[
                'episode_id' => 6
                ,'system_id'  => '6663DE9B-9076-3670-C50A-94EE64016AB6'
                ,'system_name' => 'New Episode Created'
                ,'system_name_slug' => 'new_episode_created'
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
           
        ]

];
