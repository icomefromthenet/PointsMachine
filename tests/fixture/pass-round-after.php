<?php
return [
    
      'pt_transaction_header' => [
        
        [
            'event_id'           => 1
            ,'system_ep'         => 1
            ,'zone_ep'           => 1
            ,'event_type_ep'     => 1
            ,'created_date'      => (new DateTime('now'))->format('Y-m-d')
            ,'processing_date'   => (new DateTime('now'))->format('Y-m-d')
            ,'occured_date'      => (new DateTime('now'))->format('Y-m-d')
            ,'calrunvalue'       => 134.56
            ,'calrunvalue_round' => 135    
        ]
        
    ] 
  
];