<?php
return [
    'pt_result_common' => 
    [
        
        /* Valid Record */
        [
             'slot_id' => 1
            ,'system_ep'  => 1
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
    
            ,'system_zone_ep' => 1
            ,'system_zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
            
            ,'event_type_ep' => 1
            ,'event_type_id' =>  'AE825846-3F9B-5FF7-D414-F46890E5C733' // Donation Event Type
        
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            
            ,'rule_chain_ep' => 2
            ,'rule_chain_id' => '78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5' //Withdrawal Chain
        
        ]
        
        /* Valid Record with no zone */
        ,[
             'slot_id' => 2
            ,'system_ep'  => 1
            ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF' 
            
            ,'system_zone_ep' => null
            ,'system_zone_id' => '' // no zone given
            
            ,'event_type_ep' =>  2
            ,'event_type_id' =>  '93B19460-04F4-85CD-6553-00D7125CFDAE' //Withdrawal Event Type
            
            ,'event_id' => 1
            ,'processing_date' => (new DateTime('now'))->format('Y-m-d')
            
            ,'rule_chain_ep' => 1
            ,'rule_chain_id' => '6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE' //Withdrawal Chain
        ]
        
        
    ]
];
