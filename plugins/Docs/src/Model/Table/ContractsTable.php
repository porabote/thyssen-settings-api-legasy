<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;


class ContractsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Cities');
        $this->belongsTo('Patterns');
        $this->belongsTo('Users');

        $this->belongsToMany('Contractors');


        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);

    }

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ],
	    'pattern_id' => [ 'rules' => [ 'notEmpty' ] ],
	    //'city_id' => [ 'rules' => [ 'notEmpty' ] ],
	    'summa' => [ 'rules' => [ 'notEmpty' ] ],
	    'number' => [ 'rules' => [ 'notEmpty' ] ]      
    ];


    public $contain_map = [
	    'id' => [
            'pattern' => '{{id}}',
            'index' => [
	            'width' => '65px',
	            'show' => 1
            ]
	    ],
	    'user_id' => [
            'leftJoin' => 'Users',
            'pattern' => '<span class="post-info"> <span class="post-name">{{user.full_name}}</span></span>',
            'index' => [
	            'width' => '200px',
	            'show' => 1
            ]
	    ],
	    'city_id' => [
            'leftJoin' => 'Cities',
            'pattern' => '<span class="post-info"> <span class="post-name">{{city.name}}</span></span>',
            'index' => [
	            'width' => '200px',
	            'show' => 1
            ]
	    ],
	    'summa' => [
		    'pattern' => '<span>{{summa}}</span>',
            'index' => [
	            'width' => '120px',
	            'show' => 1
            ]
	    ],
	    'name' => [
            'pattern' => '<span class="cell-info"><span class="cell-item_title">{{name}}</span> <span class="cell-item_describe">{{text}}</span></span>',
            'index' => [
	            'width' => '290px',
	            'show' => 1
            ]
	    ],
	    'date_during' => [
            'pattern' => '{{date_from}} / {{date_to}}',
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Docs.Contracts',
	            'where' => [ 'model_alias' => 'Docs.Contracts' ],
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'input',
				'operator_logical' => 'OR'	            
	        ],
	        'db_params' => [
		        'comment' => 'Срок действия'
	        ]
	    ],
	    'user_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'pattern_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'date_created_format' => [
            'index' => [
	            'show' => 1
            ]
	    ],
	    'cache_html' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'cache_data' => [
            'index' => [
	            'show' => 0
            ]
	    ]
    ];



    public $links = [
        'table' => [ 	    
		    'main' => [
			        'link' => '/docs/contracts/view/',
			        'param' => [ 'id' ],
			        'attr' => [  
			            'escape' => false 
			        ]
		        ]  
        ],
        'submenu' => [ 
              'Редактировать <span class="lnr lnr-pencil"></span>' => [
      	        'link' => '/docs/contracts/view/',
      	        'param' => [ 'id' ],
      	        'attr' => [ 
      	            'class' => 'hide-blok__link', 
      	            'escape' => false 
      	        ]
              ],
		        
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Docs.Contracts/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить документ?' } }"
			        ]
		        ]   	    
        ]
    ];

}

