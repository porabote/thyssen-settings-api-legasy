<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PeoplesTable extends Table 
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated_at' => 'always',
                ]
            ]
        ]);

        $this->hasOne('Contractors', [
            'foreignKey' => 'record_id',
            'className' => 'Contractors',
        ])->setName('Contractors')->setConditions(['model' => 'Peoples']);

        $this->hasMany('Facsimiles', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'label' => 'facsimile', 'model_alias' => 'Peoples' ]
        ]);

        $this->hasMany('Phones', [
            'foreignKey' => 'record_id',
            'className' => 'Contacts',
            'conditions' => [ 'model_alias' => 'Peoples', 'type' => 'phone', 'flag' => 'on' ]
        ]);

        $this->hasMany('Emails', [
            'foreignKey' => 'record_id',
            'className' => 'Contacts',
            'conditions' => [ 'model_alias' => 'Peoples', 'type' => 'email', 'flag' => 'on' ]
        ]);

        $this->hasMany('Posts');

        $this->belongsTo('Users', [
            'foreignKey' => 'userdata_id',
            'joinType' => 'LEFT'
        ]);
    }

    /* 
	 *  Default validation list Rules
     */
    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty', 
	            'cyrillicLetters'
	        ]
        ],
	    'last_name' => [
	        'rules' => [
	            'notEmpty', 
	            'cyrillicLetters'
	        ]
        ],
	    'fio_sclon' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ],
	    'serie' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,4] ] ] , 
	    'number' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,6] ] ] , 
	    'branch_code' => [ 'rules' => [ 'between' => [0,10] ] ]                       
    ];



    public $contain_map = [
	    'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'contain' => [],
	    'table' => [
	        'full_name' => [
	         'link' => '/peoples/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="hide-blok__link__icon edit"></span>' => [
	            'link' => '/peoples/edit/',
	            'param' => [ 'id' ],
	            'attr' => [ 
	                'class' => 'hide-blok__link', 
	                'escape' => false 
	            ]
	        ],		        
		    'Удалить <span class="hide-blok__link__icon trash">' => [
			    'link' => '/basemaps/deleteRecord/Peoples/',
			    'param' => [ 'id' ],
			    'attr' => [ 
			        'class' => 'hide-blok__link sidebar-open', 
			        'escape' => false,
			        'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить данные физиского лица?' } }"
			    ]
		    ]		         	    
	    ]
	];


}
