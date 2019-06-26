<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Component\HistoryComponent;
use Cake\Http\Session;
use App\Model\Table\Router;

class PurchaseRequestTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('purchase_request');
        
        $this->belongsTo('Users');
        $this->belongsTo('Initators', [ 'className' => 'Posts', 'joinTable' => 'posts' ]);
        $this->belongsTo('Departments', [ 'className' => 'Departments' ]);
        $this->belongsTo('Objects', [ 'className' => 'Departments', 'joinTable' => 'departments' ]);
        $this->belongsTo('Places', [ 'className' => 'Departments', 'joinTable' => 'departments' ]);
        $this->belongsTo('Statuses', [
	        'conditions' => [ 'Statuses.model_alias' => 'App.PurchaseRequest' ]
        ]);
        $this->belongsTo('DepartmentNow', [
            'foreignKey' => 'department_now_id',
            'className' => 'Departments',
            'propertyName' => 'department_now_id'
        ]);
        $this->belongsTo('Creator', [
            'foreignKey' => 'user_id',
            'className' => 'Posts',
            'propertyName' => 'creator'
        ]);        
        
        $this->belongsTo('WhoSignQueue', [
            'foreignKey' => 'who_sign_queue_id',
            'className' => 'Posts',
            'propertyName' => 'who_sign_queue_id'
        ]);
        
        $this->hasMany('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'model_alias' => 'PurchaseRequest', 'flag' => 'on' ]
        ]);
        $this->hasMany('PurchaseNomenclatures', [
            'foreignKey' => 'request_id',
            'propertyName' => 'nomenclatures'
        ]);        
                

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new'
                ]
            ]
        ]);
        
    }

    public function beforeSave($event, $entity, $options) {

        $session = new Session();
        if(!$entity->user_id) $entity->user_id = $session->read('Auth.User.id');
        //if(!$entity->user_id) $entity->manager_id = $session->read('Auth.User.id');

		# Форматируем дату публикации		
		if(!empty($_POST['date_deadline'])) $entity->date_deadline = date("Y-m-d H:i:s", strtotime($_POST['date_deadline']));
    }


    public $check_list = [
        'department_id' => [ 
            'rules' => [ 
                'notEmpty' 
            ] 
        ],
        'object_id' => [ 
            'rules' => [ 
                'notEmpty' 
            ] 
        ],
        'initator_id' => [ 
            'rules' => [ 
                'notEmpty' 
            ] 
        ],
        'place_id' => [ 
            'rules' => [ 
                'notEmpty' 
            ] 
        ],
        'user_id' => [ 
            'rules' => [ 
                'notEmpty' 
            ] 
        ]                 
    ];


    public $contain_map = [
	    'id' => [
	        'pattern' => '<a href="/purchaseRequest/view/{{id}}/">{{id}}</a>',
	        'index' => [
		        'width' => '70px',
		        'show' => 1
	        ]
	    ],
	    'object_id' => [
		    'leftJoin' => 'Objects',
	        'pattern' => '{{object.name}}',
	        'index' => [
		        'width' => '150px',
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
				'operator_logical' => 'OR',
				'where' => ['custom_type' => '5']	
	        ]
	    ],
	    'initator_id' => [
		    'leftJoin' => 'Initators',
	        'pattern' => '<span class="post-info"><span class="post-fio">{{initator.fio}}</span> <span class="post-name">{{initator.name}}</span></span>',
	        'cell-value' => '{{initator_id}}',
	        'index' => [
		        'width' => '193px',
		        'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Posts',
	            'url' => '/posts/getFindList/',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'	
	        ] 
	    ],
	    'department_id' => [
		    'leftJoin' => 'Departments',
	        'pattern' => '{{department.name}}',
	        'index' => [
		        'width' => '193px',
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
	        ]
	    ],
	    'status_id' => [
		    'leftJoin' => 'Statuses',
	        'pattern' => '{{status.name}}',
	        'index' => [
		        'width' => '154px',
		        'show' => 1
            ]
	    ],
	    'who_sign_queue_id' => [
		    'leftJoin' => 'WhoSignQueue',
	        'pattern' => '<span class="post-info"><span class="post-fio">{{who_sign_queue_id.fio}}</span> <span class="post-name">{{who_sign_queue_id.name}}</span></span>',
	        'cell-value' => '{{who_sign_queue_id.id}}',
	        'filter' => [
		        'modelName' => 'Posts',
	            'url' => '/posts/getFindList/',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'	
	        ],
	        'index' => [
		        'width' => '220px',
		        'show' => 1
            ]
	    ],
	    'department_now_id' => [
		    'leftJoin' => 'DepartmentNow',
	        'pattern' => '{{department_now_id.name}}',
	        'index' => [
		        'width' => '220px',
		        'show' => 1
            ]
	    ],
	    'comment' => [
	        'pattern' => '<span class="word-break">{{comment}}</span>',
	        'index' => [
		        'width' => '250px',
		        'show' => 1
            ],
            'db_params' => [
              'comment' => 'Общий комментарий'
            ]
	    ],
	    'date_created' => [
		    'index' => [
		        'width' => '110px',
		        'show' => 1
            ] 
	    ],
	    'priority_id' => [
	        'pattern' => '{% if priority_id %}Cрочно{% else %}Не срочно{% endif %}',
	        'index' => [
		        'width' => '110px',
		        'show' => 1
            ]
	    ],
	    'nmcl_count' => [
	        'index' => [
		        'show' => 0
            ]
        ],
        'user_id' => [
	        'index' => [
	    	    'show' => 0
            ]
        ]
    ];


	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/purchaseRequest/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	];



    
}
