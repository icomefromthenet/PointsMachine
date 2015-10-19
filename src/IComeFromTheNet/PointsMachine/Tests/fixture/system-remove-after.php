<?php
return [
        'pt_system' => 
        [
            /* Inactive from now  */
            [
                'episode_id' => 1
                ,'system_id'  => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'system_name' => 'Test Donations System'
                ,'system_name_slug' => 'test_donations_system'
                ,'enabled_from' => (new DateTime('today - 7 day'))->format('Y-m-d')
                ,'enabled_to'   => (new DateTime())->format('Y-m-d')
            ]
            
        ]
      
    
];