<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DirectionsTable extends Table 
    {

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]      
    ];

    public $contain_map = [
	    'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'contain' => [],
	    'table' => [
	        'name' => [
	         'link' => '/departments/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="lnr lnr-pencil"></span>' => [
	         'link' => '/departments/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link sidebar-open', 
	             'escape' => false 
	         ]
	        ],
		    'Удалить <span class="lnr lnr-trash">' => [
			    'link' => '/basemaps/deleteRecord/departments/',
			    'param' => [ 'id' ],
			    'attr' => [ 
			        'class' => 'hide-blok__link sidebar-open', 
			        'escape' => false,
			        'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить запись?' } }"
			    ]
		    ]		         	    
	    ]
	];


    public static function defaultConnectionName()
    {
        return 'systems';
    }

    public function initialize(array $config)
    {

       // $this->belongsTo('Contractors');       


    }


}
