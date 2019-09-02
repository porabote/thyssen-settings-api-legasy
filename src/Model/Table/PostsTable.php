<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PostsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Peoples');
        $this->belongsTo('Contractors');
        $this->belongsTo('Departments');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');
/*
        $validator
            ->allowEmpty('number');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('comments', 'create')
            ->notEmpty('comments');
*/
        return $validator;
    }



    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Укажите наименование должности' ]
	        ]
        ],
	    'people_id' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]       
    ];

    public $contain_map = [
        'people_id' => [
	        'leftJoin' => 'Peoples',
            'pattern' => '<span class="cell-item_title"> {{people.last_name}} {{people.name}} {{people.middle_name}} </span>',
            'index' => [
	            'width' => '300px',
	            'show' => 1
            ],
            'db_params' => [
				'comment' => 'ФИО физ. лица'
			]
	    ],
	    'name' => [
            'pattern' => '<span class="cell-item_title">{{name}}</span>',
            'index' => [
	            'width' => '250px',
	            'show' => 1
            ]
	    ],
	    'department_id' => [
		    'leftJoin' => 'Departments',
	        'pattern' => '{{department.name}}',
	        'index' => [
		        'width' => '301px',
		        'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Departments',
	            'url' => '/departments/getFindList/',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'	
	        ],
            'db_params' => [
				'comment' => 'Отдел'
			]
	    ],
	    'contractor_id' => [
            'index' => [
	            'width' => '300px',
	            'show' => 0
            ]
	    ],
	    'email' => [
            'pattern' => '<span class="cell-item_title">{{email}}</span>',
            'index' => [
	            'width' => '250px',
	            'show' => 1
            ]
	    ]

    ];  


	public $links = [
		    'contain' => [],
		    'table' => [
		        'name' => [
			        'link' => '/posts/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'table__link', 
			            'escape' => false 
			        ]
		        ] 	    
		    ],
		    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/posts/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/posts/',
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
