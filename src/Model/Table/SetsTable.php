<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SetsTable extends Table 
    {

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]      
    ];

    public $contain_map = [
	    'ctype_id' => [ 'model' => 'CustomTypes', 'alias' => 'CustomTypes', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'contain' => [],
	    'table' => [
	        'name' => [
	         'link' => '/sets/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="lnr lnr-pencil"></span>' => [
	         'link' => '/sets/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link', 
	             'escape' => false 
	         ]
	        ],
		    'Удалить <span class="lnr lnr-trash">' => [
			    'link' => '/basemaps/deleteRecord/sets/',
			    'param' => [ 'id' ],
			    'attr' => [ 
			        'class' => 'hide-blok__link sidebar-open', 
			        'escape' => false,
			        'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить запись?' } }"
			    ]
		    ]		         	    
	    ]
	];


    public function initialize(array $config)
    {
        $this->belongsToMany('Products', ['dependent' => true]);
        $this->belongsToMany('Ordergroups');
       // $this->belongsToMany('Setgroups');
        $this->belongsTo('CustomTypes', [ 'foreignKey' => 'ctype_id' ]);
      


        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new'
                ]
            ]
        ]);

    }


}
