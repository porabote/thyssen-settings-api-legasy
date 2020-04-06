<?php
namespace Store\Model\Table;

use Cake\ORM\Table;


class BillsTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('contract_extantions');        

        $this->belongsTo('Docs.ContractSets', [
	        'foreignKey' => 'set_id',
        ]);
        
        $this->belongsTo('Objects', [ 'className' => 'Departments', 'joinTable' => 'departments' ]);
        $this->belongsTo('Contractors', [ 'className' => 'Contractors', 'joinTable' => 'contractors' ]);
        $this->belongsTo('Clients', [ 'className' => 'Contractors', 'joinTable' => 'contractors' ]);
        $this->belongsTo('Managers', [ 'className' => 'Posts', 'joinTable' => 'posts' ]);

        $this->belongsTo('Statuses');

        $this->belongsTo('WhoSignQueue', [
            'foreignKey' => 'who_sign_queue_id',
            'className' => 'Posts',
            'propertyName' => 'who_sign_queue_id'
        ]);

        $this->hasMany('PurchaseNomenclatures', [
            'foreignKey' => 'bill_id',
            'propertyName' => 'nomenclatures',
            //'conditions' => [ 'PurchaseNomenclatures.parent_id IS NOT' => null ]
        ]);

        
        $this->hasMany('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'model_alias' => 'Docs.ContractExtantions', 'flag' => 'on' ]
        ]);

    }

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ],
	    'last_name' => [ 'rules' => [ 'notEmpty' ] ],
	    'middle_name' => [ 'rules' => [ 'notEmpty' ] ]     
    ];

    public $contain_map = [
      
      'contractor_id' => [
		    'leftJoin' => 'Contractors',
	        'pattern' => '{{contractor.name}}',
	        'filter' => [
		        'modelName' => 'Contractors',
	            'url' => '/contractors/getFindList/',
	            'where' => [ 'type' => 'client', 'c_id >=' => '1' ],
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
            ],
	        'index' => [
	            'width' => '212px',
	            'show' => 1
            ],
            'db_params' => [
                'comment' => 'Поставщик'
            ]
	    ],
	    'number' => [
            'pattern' => '<b>{{number}}</b><br> от {{date}}',
            'cell-value' => '{{id}}',
            'index' => [
	            'width' => '180px',
	            'show' => 1
            ],
            'db_params' => [
                'comment' => 'Номер/Дата'
            ]
	    ],
	    'date' => [
            'pattern' => '{{date}}',
            'index' => [
	            'width' => '120px',
	            'show' => 0
            ]
	    ],
	    'status_id' => [
		    'leftJoin' => 'Statuses',
	        'pattern' => '{{status.name}}',
	        'index' => [
	            'width' => '150px',
	            'show' => 1
            ]
	    ],
	    'summa' => [
            'pattern' => '{{summa}}',
            'index' => [
	            'width' => '120px',
	            'show' => 1
            ]
	    ],
	    'currency' => [
            'pattern' => '{{currency}}',
            'index' => [
	            'width' => '75px',
	            'show' => 1
            ]
	    ],
	    'date_to' => [
            'pattern' => '{{date_to}}',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ]
	    ],
	    'pay_plan' => [
            'pattern' => '{{pay_plan}}',
            'index' => [
	            'width' => '110px',
	            'show' => 1
            ]
	    ],
	    'pay_plan' => [
            'pattern' => '{{pay_plan}}',
            'index' => [
	            'width' => '110px',
	            'show' => 1
            ]
	    ],
        'object_id' => [
	    	'leftJoin' => 'Objects',
	        'pattern' => '{{object.name}}',
	        'filter' => [
	    	    'modelAlias' => 'Departments',
	            'url' => '/departments/getAjaxList/',
	            'uri' => '{
		            "where" : {"custom_type" : "5"}
	            }',
	            'readonly' => 'readonly',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
	              'width' => '150px',
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
				'operator_logical' => 'AND'	
	        ],
	        'index' => [
		        'width' => '220px',
		        'show' => 1
            ],
            'db_params' => [
                'comment' => 'На подписи у'
            ]
	    ],
        'manager_id' => [
	    	'leftJoin' => 'Managers',
	        'pattern' => '{{manager.fio}}',
	        'filter' => [
	    	    'modelName' => 'Posts',
	            'url' => '/posts/getFindList/',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
	              'width' => '150px',
	              'show' => 1
            ] 
	    ],
        'id' => [
		    'index' => [
			    'width' => '40px',
                'show' => 0
		    ]
	    ],
	    'client_id' => [
		    'leftJoin' => 'Clients',
	        'pattern' => '{{client.name}}',
	        'filter' => [
		        'modelName' => 'Contractors',
	            'url' => '/contractors/getFindList/',
	            'where' => [ 'type' => 'self', 'c_id >=' => '1' ],
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'	            
	        ],
	        'index' => [
                'show' => 0
		    ]
	    ],
	    'name' => [
		    'index' => [
                'show' => 0
		    ],
            'db_params' => [
                'comment' => 'Название'
            ]
	    ],
	    'alias' => [
		    'index' => [
                'show' => 0
		    ],
            'db_params' => [
                'comment' => 'Алиас на латинице'
            ]
	    ],
	    'purchase_id' => [
		    'index' => [
                'show' => 0
		    ]
	    ],
	    	    
    ];

	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/store/bills/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ]
	];

}
