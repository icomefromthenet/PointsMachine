<?php
return [
        'pt_system' => 
        [
            /* No relations linked here */
            [
                'episode_id' => 2
                ,'system_id'  => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'system_name' => 'Test Donations System'
                ,'system_name_slug' => 'test_donations_system'
                ,'enabled_from' => (new DateTime('today - 7 day'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
            /* The names have been updated (non-temporal update so no new version)*/
            ,[
                'episode_id' => 3
                ,'system_id'  => '5CC68937-12BF-C9B9-97E0-3745649101F4'
                ,'system_name' => 'Test Donations System'
                ,'system_name_slug' => 'test_donations_system'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
        ]

];
