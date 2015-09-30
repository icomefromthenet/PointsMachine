<?php

return [
     'pt_system' => [
        ['episode_id' => null,
         'system_id'  => '9B753E70-881B-F53E-2D46-8151BED1BBAF',
         'system_name' => 'test 1',
         'system_name_slug' => 'test_1',
         'enabled_from' => date('YYYY-MM-DD HH:MM:SS'),
         'enabled_to'   => DateTime::createFromFormat('d-m-Y','01-01-3000')->format('YYYY-MM-DD HH:MM:SS')
          ]
    ]
];