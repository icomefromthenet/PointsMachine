<?php
return [
        'pt_system' => 
        [
            [
                'episode_id' => 1
                ,'system_id'  => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'system_name' => 'Donations System'
                ,'system_name_slug' => 'donations_system'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
        ]
        ,'pt_system_zone' => 
        [
            [
               'episode_id' => 1
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
               ,'zone_name' => 'Healer'
               ,'zone_name_slug' => 'healer'
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
               
            
            ]
            ,[
               'episode_id' => 2
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => 'F4CDA42C-07F9-7DCE-3AC4-74994CFC2286'
               ,'zone_name' => 'Tank'
               ,'zone_name_slug' => 'tank'
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
               
            
            ]
            ,[
               'episode_id' => 3
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '5A6DB8CB-364F-6290-8C03-3BA6872B5D3F'
               ,'zone_name' => 'Mage'
               ,'zone_name_slug' => 'mage'
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
               
            
            ]
            ,[
               'episode_id' => 4
               ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
               ,'zone_id' => '578A182E-7EB9-689F-B497-6AE8772E41B1'
               ,'zone_name' => 'Rogue'
               ,'zone_name_slug' => 'rogue'
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to' => (new DateTime('3000-01-01'))->format('Y-m-d')
            ]   
            
        ]
        ,'pt_event_type' => 
        [
            [
                'episode_id' => 1
                ,'event_type_id' => 'AE825846-3F9B-5FF7-D414-F46890E5C733'
                ,'event_name' => 'Donation'
                ,'event_name_slug' => 'donation'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            ,
             [
                'episode_id' => 2
                ,'event_type_id' => '93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'event_name' => 'Withdrawal'
                ,'event_name_slug' => 'withdrawal'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to' =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
        ]
        
        ,'pt_event' => 
        [
            [ /* Donation Event Instance  */
                 'event_id'     =>  1
                ,'event_type_id' => 'AE825846-3F9B-5FF7-D414-F46890E5C733'
                ,'process_date' => (new DateTime())->format('Y-m-d')
                ,'occured_date' => (new DateTime())->format('Y-m-d')
                
            ]        
        ]
        ,'pt_score_group' => 
        [
            [
                'episode_id'       => 1
                ,'score_group_id'  => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'group_name'      => 'Enchanting Supplies'
                ,'group_name_slug' => 'enchanting_supplies'
                ,'enabled_from'    => (new DateTime())->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ]
            ,
            [
                'episode_id'       => 2
                ,'score_group_id'  => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
                ,'group_name'      => 'Alchemy Supplies'
                ,'group_name_slug' => 'alchemy_supplies'
                ,'enabled_from'    => (new DateTime())->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ]
            ,
            [
                'episode_id'       => 3
                ,'score_group_id'  => '010918BD-81B9-BA96-FE54-B64319AB1FA1'
                ,'group_name'      => 'Herbalism Supplies'
                ,'group_name_slug' => 'herbalism_supplies'
                ,'enabled_from'    => (new DateTime())->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
            
            ]
            ,[
               'episode_id'       => 4
                ,'score_group_id'  => '19E964BC-B8B3-ACED-9AAA-96E456ADEB71'
                ,'group_name'      => 'Recipes'
                ,'group_name_slug' => 'recipes'
                ,'enabled_from'    => (new DateTime())->format('Y-m-d')
                ,'enabled_to'      => (new DateTime('3000-01-01'))->format('Y-m-d')
                
            ]
            
            
        ]
        ,'pt_score' => 
        [
            
            /* Enchanting Scrore Group */
            [
                'episode_id'   => 1
                ,'score_id'     => '755D1FFF-A190-9F70-21A1-3BCFAB7A60AA'
                ,'score_name' => 'Crystal Shard'
                ,'score_name_slug' => 'crystal_shard'
                ,'score_value'   => 0.5
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]    
            , 
            [
                'episode_id'   => 2
                ,'score_id'     => '66C19B18-0C52-29A2-09CE-0D9021EDB0CB'
                ,'score_name' => 'Magic Dust'
                ,'score_name_slug' => 'magic_dust'
                ,'score_value'   => 0.2
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ] 
            , 
            [
                'episode_id'   => 3
                ,'score_id'     => 'EA30F35F-71E4-0055-D3D5-C580970C84FF'
                ,'score_name' => 'Magic Jewel'
                ,'score_name_slug' => 'magic_jewel'
                ,'score_value'   => 0.8
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
            /* Alchemy Scrore Group */
            ,[
                'episode_id'   => 4
                ,'score_id'     => 'EAF0B47C-B1AA-5867-DDF0-6B09AB03FDA0'
                ,'score_name' => 'Healing Pot'
                ,'score_name_slug' => 'healing_pot'
                ,'score_value'   => 0.5
                ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]  
            ,[
                'episode_id'   => 5
                ,'score_id'     => 'ABC92D3D-4707-44BA-1653-F6A711757169'
                ,'score_name' => 'Mana Pot'
                ,'score_name_slug' => 'mana_pot'
                ,'score_value'   => 0.5
                ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]  
             ,[
                'episode_id'   => 6
                ,'score_id'     => '6BF3512D-462C-6464-964B-177E671581A0'
                ,'score_name' => 'Defensive Buff Pot'
                ,'score_name_slug' => 'defensive_buff_pot'
                ,'score_value'   => 0.5
                ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ] 
            ,[
                'episode_id'   => 7
                ,'score_id'     => '474AF45D-7D2D-D311-53D9-192D236B430F'
                ,'score_name' => 'Offensive Buff Pot'
                ,'score_name_slug' => 'offensive_buff_pot'
                ,'score_value'   => 0.5
                ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ] 
            /* Herbalism Scrore Group */
            ,[
                'episode_id'   => 8
                ,'score_id'     => '4085B370-A8B0-81B7-5233-F1ADBC6CFF63'
                ,'score_name' => 'Common Herb'
                ,'score_name_slug' => 'common_herb'
                ,'score_value'   => 0.3
                ,'score_group_id' => '010918BD-81B9-BA96-FE54-B64319AB1FA1'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ] 
            ,[
                'episode_id'   => 9
                ,'score_id'     => 'D4E1FF6B-8630-B2BF-2E28-FB3B32FA5079'
                ,'score_name' => 'Uncommon Herb'
                ,'score_name_slug' => 'uncomman_herb'
                ,'score_value'   => 0.5
                ,'score_group_id' => '010918BD-81B9-BA96-FE54-B64319AB1FA1'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ] 
            ,[
                'episode_id'   => 10
                ,'score_id'     => '0A304D9A-B002-4D46-7D4E-4D9EBE723C31'
                ,'score_name' => 'Rare Herb'
                ,'score_name_slug' => 'rare_herb'
                ,'score_value'   => 1
                ,'score_group_id' => '010918BD-81B9-BA96-FE54-B64319AB1FA1'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]  
            /* Recipe Scrore Group */
            ,[
                'episode_id'   => 11
                ,'score_id'     => '6B4F8F56-5035-F088-953B-EC7FFAD9C43'
                ,'score_name' => 'Recipe'
                ,'score_name_slug' => 'recipe'
                ,'score_value'   => 1
                ,'score_group_id' => '19E964BC-B8B3-ACED-9AAA-96E456ADEB71'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            
            
        ]
       
        ,'pt_rule_group' =>
        [
            /* Withdrawal Event Groups */
            [
                /* Withdrawal Conversion */ 
                'episode_id' => 1
                ,'rule_group_id' => '5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'rule_group_name' => 'Withdrawal Conversion'
                ,'rule_group_name_slug'=> 'withdrawal_conversion'
                ,'max_multiplier' => null
                ,'min_multiplier' => null
                ,'max_modifier' => 5
                ,'min_modifier' => 0.1
                ,'max_count' => 1
                ,'order_method' => null
                ,'is_mandatory' => 1
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
            ]
            ,
            [
                /* Discounts */ 
                'episode_id' => 2
                ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'rule_group_name' => 'Discounts'
                ,'rule_group_name_slug'=> 'discounts'
                ,'max_multiplier' => 10
                ,'min_multiplier' => 10
                ,'max_modifier' => 100
                ,'min_modifier' => 8
                ,'max_count' => 1
                ,'order_method' => 1
                ,'is_mandatory' => 1
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')
                
                
            ]
            
        ]
      
        ,'pt_rule_group_limits' =>
        [
            
            /* Withdrawal Convserion Relations */
            
            [
                /* Link to System */
                'episode_id' => 1
                ,'rule_group_id' => '5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'score_group_id' => null
                ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')  
            ]
            
            ,[
                /* Enchanting Score Group */
                'episode_id' => 2
                ,'rule_group_id' => '5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')  
            ]
            
            ,[
                /* Alchmey Score Group */
                'episode_id' => 3
                ,'rule_group_id' => '5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            ,[
                 /* Herb Score Group */
                'episode_id' => 4
                ,'rule_group_id' => '5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'score_group_id' => '010918BD-81B9-BA96-FE54-B64319AB1FA1'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            ,[
                /* Recepies Score Group */
                'episode_id' => 5
                ,'rule_group_id' => '5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'score_group_id' => '19E964BC-B8B3-ACED-9AAA-96E456ADEB71'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            /* Discounts */ 
            
            ,[
                /* Link to System */
                'episode_id' => 6
                ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'score_group_id' => null
                ,'system_id' => '9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')  
            ]
            
            ,[
                /* Enchanting Score Group */
                'episode_id' => 7
                ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'score_group_id' => 'B1FEA3E0-1568-6C33-2519-14FBCC13BCED'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d')  
            ]
            
            ,[
                /* Alchmey Score Group */
                'episode_id' => 8
                ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'score_group_id' => 'B123E69A-9055-8593-38AD-7BF7B6E138FC'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            ,[
                 /* Herb Score Group */
                'episode_id' => 9
                ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'score_group_id' => '010918BD-81B9-BA96-FE54-B64319AB1FA1'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            ,[
                /* Recepies Score Group */
                'episode_id' => 10
                ,'rule_group_id' => '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'score_group_id' => '19E964BC-B8B3-ACED-9AAA-96E456ADEB71'
                ,'system_id' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            
        ]
        
        ,'pt_rule' => 
        [
            /* Withdrawal Convsersion */
            
            [  
                'episode_id' => 1
                ,'rule_id' => '352F04DC-7338-A56F-75F8-29CC51B35EBE'
                ,'rule_group_id' =>'5515F1B4-A824-30BD-0971-049495BCDB22'
                ,'rule_name' => 'Convert to Negative'
                ,'rule_name_slug' => 'convert_to_negative'
                ,'multiplier' =>1
                ,'modifier' => null
                ,'invert_flag' =>1
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            
            /* Discounts */
            
            ,[
                'episode_id' => 2
                ,'rule_id' => 'D39CDDFB-09DF-00F1-ED5B-ECE0C04782CD'
                ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD' 
                ,'rule_name' => 'Big Discount'
                ,'rule_name_slug' => 'big_discount'
                ,'multiplier' => 0.8
                ,'modifier' => null
                ,'invert_flag' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            ,[
                'episode_id' => 3
                ,'rule_id' => '3235B350-593C-7F7C-22BD-6089A36C155B'
                ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'rule_name' => 'Medium Discount'
                ,'rule_name_slug' => 'medium_discount'
                ,'multiplier' => 0.4
                ,'modifier' => null
                ,'invert_flag' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            ,[
                'episode_id' => 4
                ,'rule_id' => '61C6CA0C-2896-D97E-0A39-673121D4AF52'
                ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'rule_name' => 'Small Discount'
                ,'rule_name_slug' => 'small_discount'
                ,'multiplier' => 0.2
                ,'modifier' => null
                ,'invert_flag' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
            ]
            ,[
                 'episode_id' => 5
                ,'rule_id' => 'EAF03EED-16AC-557E-6267-7F54ADD83197'
                ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'rule_name' => 'Healer Discount'
                ,'rule_name_slug' => 'healer_discount'
                ,'multiplier' => 0.5
                ,'modifier' => null
                ,'invert_flag' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
                
            ]
             ,[
                 'episode_id' => 6
                ,'rule_id' => '7D4D8D11-7582-72BC-F9CB-7FD0CC8354A9'
                ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
                ,'rule_name' => 'Tank Discount'
                ,'rule_name_slug' => 'tank_discount'
                ,'multiplier' => 0.5
                ,'modifier' => null
                ,'invert_flag' => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
                
                
            ]
            

        ]
        
        ,'pt_rule_sys_zone' => 
        [
            /* Link Tank and header rules to there class zones */
            [
                'episode_id' => 1
                ,'rule_id' => 'EAF03EED-16AC-557E-6267-7F54ADD83197'
                ,'zone_id' => '03D119A2-1B66-423C-401F-7CE384450CE5'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ]
            ,[
                'episode_id' => 2
                ,'rule_id' => '7D4D8D11-7582-72BC-F9CB-7FD0CC8354A9'
                ,'zone_id' => 'F4CDA42C-07F9-7DCE-3AC4-74994CFC2286'
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ]
            
            
        ]
        
        ,'pt_rule_chain' =>
        [
            /* Withdrawal Event Chain */
            [
                'episode_id' => 1
                ,'rule_chain_id'  =>'6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE'
                ,'event_type_id'  =>'93B19460-04F4-85CD-6553-00D7125CFDAE'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'Withdrawal Chain'
                ,'chain_name_slug'  =>'withdrawal_chain'
                ,'rounding_option' => 2
                ,'cap_value'    => -120
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ]
            
             /* Donation Event Chain */
            ,[
                'episode_id' => 2
                ,'rule_chain_id'  =>'78841FAC-F8F2-F7F9-ECF3-6A749BEFD0F5'
                ,'event_type_id'  =>'AE825846-3F9B-5FF7-D414-F46890E5C733'
                ,'system_id'  =>'9B753E70-881B-F53E-2D46-8151BED1BBAF'
                ,'chain_name'  =>'Donation Chain'
                ,'chain_name_slug'  =>'donations_chain'
                ,'rounding_option' => 0
                ,'cap_value'    => null
                ,'enabled_from' => (new DateTime())->format('Y-m-d')
                ,'enabled_to'   =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
            ]
            
            
        ]
        
        ,'pt_chain_member' =>
        [
            /* Withdrawal Event Chain */
            [
               /* Discounts */
               'episode_id' => 1
               ,'chain_member_id' =>'6A650CC9-223E-02A3-2F89-22D650272237'
               ,'rule_chain_id' =>'6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE'
               ,'rule_group_id' =>'586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
               ,'order_seq' => 1
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
               
            ]
            ,
            [
                /* Withdrawal Conversion */
               'episode_id' => 2
               ,'chain_member_id' =>'3574D960-C4B4-9C44-F5C4-84C15CCA60EA'
               ,'rule_chain_id' =>'6BFF307B-E04F-9D98-5C6D-0C3B8D3AF5BE'
               ,'rule_group_id' =>'5515F1B4-A824-30BD-0971-049495BCDB22'
               ,'order_seq' => 2
               ,'enabled_from' => (new DateTime())->format('Y-m-d')
               ,'enabled_to'  =>  (new DateTime('3000-01-01'))->format('Y-m-d') 
               
            ] 
            
        ]
        
    
];