<?php
return [
        'pt_system' => 
        [
            /* The names have been updated (non-temporal update so no new version)*/
            [
                'episode_id' => 1
                ,'system_id'  => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'system_name' => 'Test Donations System'
                ,'system_name_slug' => 'test_donations_system'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
        ]
      
    
];