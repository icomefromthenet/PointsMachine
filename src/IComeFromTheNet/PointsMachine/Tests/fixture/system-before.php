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
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
            /* Entity with enabled date of now any changes not cause a new version*/
            ,[
                'episode_id' => 3
                ,'system_id'  => '5CC68937-12BF-C9B9-97E0-3745649101F4'
                ,'system_name' => 'Test Donations System'
                ,'system_name_slug' => 'test_donations_system'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
            /* Entity with a enabled from date in the past any updates cause new episode */
             /* Entity with enabled date of now any changes not cause a new version*/
            ,[
                'episode_id' => 4
                ,'system_id'  => '6663DE9B-9076-3670-C50A-94EE64016AB6'
                ,'system_name' => 'Require New Episode'
                ,'system_name_slug' => 'require_new_episode'
                ,'enabled_from' => (new DateTime('now - 10 day'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
           
        ]

];
