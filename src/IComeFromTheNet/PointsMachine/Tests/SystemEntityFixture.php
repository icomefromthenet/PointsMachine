<?php
return [
            'pt_system' => 
            [
                // Entity with 1 past episode and one current starting from NOW
                [
                'episode_id' => null,
                'system_id'  => '9B753E70-881B-F53E-2D46-8151BED1BBAF',
                'system_name' => 'test 1',
                'system_name_slug' => 'test_1',
                'enabled_from' => (new DateTime('now -8 day'))->format('Y-m-d'),
                'enabled_to'   => (new DateTime('now -1 day'))->format('Y-m-d')
                ]
                ,[
                'episode_id' => null,
                'system_id'  => '9B753E70-881B-F53E-2D46-8151BED1BBAF',
                'system_name' => 'test 1',
                'system_name_slug' => 'test_1',
                'enabled_from' => (new DateTime('now'))->format('Y-m-d'),
                'enabled_to'   => DateTime::createFromFormat('d-m-Y','01-01-3000')->format('Y-m-d')    
                ]
                
                // Entity that is has expired
                ,[
                'episode_id' => null,
                'system_id'  => 'C341F061-0971-E8A6-18D8-9C2751A1D47B',
                'system_name' => 'expired system 1',
                'system_name_slug' => 'expired_system_1',
                'enabled_from' => (new DateTime('now -8 day'))->format('Y-m-d'),
                'enabled_to'   => (new DateTime('now -1 day'))->format('Y-m-d')
                ]
            ]
        ];