<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CatalogsTable extends Table 
    {

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]      
    ];

    public $actsAs = array('Tree');

    public $contain_map = [];


	public $links = [
	    'table' => [
	        'name' => [
	         'link' => '/catalogs/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/catalogs/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/catalogs/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить каталог?' } }"
			        ]
		        ]  	    
	    ],
	    'links' => [
		    '<a href="">'
	    ]
	];



    public function initialize(array $config)
    {
        $this->belongsToMany('Nomenclatures');       
        
        $this->addBehavior('Tree');      
    }


}
