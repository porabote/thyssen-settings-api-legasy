<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DepartmentsTable extends Table 
    {

    public function initialize(array $config)
    {
        $this->addBehavior('Tree', [ 'level' => 'level' ]);
        $this->setTable('departments');
        //$this->belongsTo('Contractors');
        
        $this->belongsTo('ParentDepartment', [
               'className' => 'Departments',
               'foreignKey' => 'parent_id'
           ]);        

        $this->hasMany('Posts'); 

    }

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]      
    ];

    public $contain_map = [
	    //'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
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


}
