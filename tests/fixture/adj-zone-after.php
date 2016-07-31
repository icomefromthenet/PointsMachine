<?php
return [
    
    'pt_rule_sys_zone' => [
        
        /* A Relation that can be closed */
        [
                'episode_id' => 3
                ,'rule_id' => 'CBEB772F-6E96-5A83-0F24-9F9B363ED240'  // example rule
                ,'zone_id' => '5E02B643-1352-C3D9-FB16-C9B9BB0C88C0' //example zone 
                ,'enabled_from' => (new DateTime('now - 1 day'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('now'))->format('Y-m-d') 
        ]
        
        /* A current relation that has been updated */
        ,[
                'episode_id' => 4
                ,'rule_id' => 'AD5B6D76-A0F5-4688-CE81-835F901CB725'  // example rule 2
                ,'zone_id' => '532CE54F-13F4-3E88-3F31-8F41EE3E6E3A' // 3rd example zone 
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
        ]
        
        
        /* A new relation */
        ,[
                'episode_id' => 5
                ,'rule_id' => 'CBEB772F-6E96-5A83-0F24-9F9B363ED240'  // example rule
                ,'zone_id' => '65E04897-6F62-3A89-A2F6-675C7105549A' // 4rd example zone 
                ,'enabled_from' => (new DateTime('now'))->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
        ]
        
      
        
    ]
    
];