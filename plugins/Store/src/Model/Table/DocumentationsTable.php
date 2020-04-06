<?php
namespace Store\Model\Table;

use Cake\ORM\Table;


class DocumentationsTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('store_documentations');        

        $this->belongsTo('Posts', [ 'className' => 'Posts', 'joinTable' => 'posts' ]);
        $this->belongsTo('Contractors');

/*
        $this->belongsTo('WhoSignQueue', [
            'foreignKey' => 'who_sign_queue_id',
            'className' => 'Posts',
            'propertyName' => 'who_sign_queue_id'
        ]);
*/

        $this->belongsTo('Statuses');

        $this->hasMany('PurchaseNomenclatures', [
            'foreignKey' => 'store_doc_id',
            'propertyName' => 'nomenclatures',
            //'conditions' => [ 'PurchaseNomenclatures.parent_id IS NOT' => null ]
        ]);

        
        $this->hasMany('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'model_alias' => 'Store.Documentations', 'flag' => 'on' ]
        ]);

    }

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ],
	    'number' => [ 'rules' => [ 'notEmpty' ] ]   
    ];

    public $contain_map = [
        'id' => [
		    'index' => [
			    'width' => '40px',
                'show' => 1
		    ]
	    ],
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
	            'width' => '200px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Контрагент'
            ]
	    ],
	    'name' => [
            'pattern' => '{{name}}',
            'index' => [
	            'width' => '300px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Наименование документа'
            ]
	    ],
	    'comment' => [
            'index' => [
	            'width' => '200px',
	            'show' => 0
            ],
            'db_params' => [
	            'comment' => 'Комментарий'
            ]
	    ],
	    'number' => [
            'pattern' => '{{number}}',
            'index' => [
	            'width' => '130px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Номер документа'
            ]
	    ],
        'status_id' => [
	    	'leftJoin' => 'Statuses',
	        'pattern' => '{{status.name}}',
	        'filter' => [
	    	    'modelName' => 'Statuses',
	            'url' => '/statuses/getFindList/',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'
	        ],
	        'index' => [
	              'width' => '150px',
	              'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Статус'
            ] 
	    ],
	    'original_movement' => [
            'pattern' => '{% if original_movement %}Передано{% else %}Не передано{% endif %}',
            'index' => [
	            'width' => '120px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Оригинал'
            ]
	    ],	    
	    'date_from' => [
            'pattern' => '{{date_from}}',
            'index' => [
	            'width' => '120px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Начало действия'
            ]
	    ],
	    'date_to' => [
            'pattern' => '{{date_to}}',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Дата истечения'
            ]
	    ],
        'post_id' => [
	    	'leftJoin' => 'Posts',
	        'pattern' => '{{post.fio}}',
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
	              'width' => '150px',
	              'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Добавил'
            ] 
	    ]
	    	    
    ];

	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/store/documentations/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ]
	];

}
