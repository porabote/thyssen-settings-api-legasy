<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class EntrepreneursTable extends Table
{
  
  
  public function initialize(array $config)
    {
        $this->belongsTo('Users');
        $this->belongsTo('Cities');
        $this->belongsTo('Taxes'); 
        $this->hasOne('Contractors', [
            'foreignKey' => 'record_id',
            'conditions' => [ 'model' => 'Entrepreneurs'],
            'dependent' => true
        ]);       

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new',
                    'count_modified' => 'always',
                ]
            ]
        ]);

    }

   public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]              
    ];



    public $contain_map = [
		'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsTo' ],
		'city_id' => [ 'model' => 'Cities', 'alias' => 'cities', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsTo' ],
    ];


	public $links = [
	    'table' => [
	        'number' => [
	         'link' => '/entrepreneurs/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	         'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/Entrepreneurs/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Entrepreneurs/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить запись?' } }"
			        ]
		        ]  	    
	    ],
	    'links' => [
		    '<a href="">'
	    ]
	];



}


