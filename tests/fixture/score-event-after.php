<?php
return [
    'pt_event' =>  [
        
        [   /* Normal Event  */
                 'event_id'     =>  2
                ,'event_type_id' => '93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'process_date' => (new DateTime('now'))->format('Y-m-d')
                ,'occured_date' => (new DateTime('now - 1 day'))->format('Y-m-d')
                
        ]  
        
        ,[   /* New Event  */
                 'event_id'     =>  3
                ,'event_type_id' => '93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'process_date' => (new DateTime('now'))->format('Y-m-d')
                ,'occured_date' => (new DateTime('now - 1 day'))->format('Y-m-d')
                
        ]  
        
    ]
    
    
];