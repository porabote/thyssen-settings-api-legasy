<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class AddressesTable extends Table
{

    public function initialize(array $config)
    {
        
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new'
                ],
                'Orders.completed' => [
                    'completed_at' => 'always'
                ]
            ]
        ]);
        
        $this->belongsTo('Contractors');
    }

    public $contain_map = [
		//'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


    public $check_list = [
	    'city_name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ],
	    'street' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ],
	    'house' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ],                
    ];

	public $links = [
	    'table' => [
	        'name' => [
	         'link' => '/addresses/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/addresses/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить запись <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Addresses/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false
			        ]
		        ]  	    
	    ],
	    'links' => [
		    '<a href="">'
	    ]
	]; 

    
}
