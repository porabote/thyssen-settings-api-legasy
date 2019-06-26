<?php
namespace Api\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContentsTable extends Table 
    {


    public function initialize(array $config)
    {


       // $this->table('contents');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users');
        $this->hasMany('Files', [
	        'foreignKey' => 'record_id',
	        'conditions' => [ 'modelmap_alias' => 'Contents' ] 
        ]);

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
	    'name' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Номенклатура не выбрана' ] ] ]      
    ];


    public $contain_map = [
	    'id' => [
            'index' => [	            
	            'width' => '50px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'ID'
            ]
	    ],
	    'name' => [
		    'pattern' => '<a href="/api/contents/view/{{id}}/"><span class="cell-info"><span class="cell-item_describe">{{name}}</span></span></a>',
            'index' => [	            
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Название'
            ]
	    ],
	    'uri' => [
		    'pattern' => '<span class="cell-info"><span class="cell-item_describe uri">{{uri}}</span></span></a>',
            'index' => [	            
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Внешняя ссылка'
            ]
	    ],
	    'flag' => [
	        'pattern' => '{% if flag == "on" %}Активна{% else %}Выключена{% endif %}',
            'index' => [
	            'width' => '80px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Флаг'
            ]
	    ],
	    'date_publicated' => [
	        'pattern' => '{{date_publicated}}',
            'index' => [
	            'width' => '140px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Дата публикации'
            ]
	    ],
	    'text_short' => [
		    'pattern' => '<a href="/api/contents/view/{{id}}/"><span class="cell-info"><span class="cell-item_describe">{{text_short|striptags}}</span></span></a>',
            'index' => [	            
	            'width' => '350px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Краткий текст'
            ]
	    ],
	    'text' => [
            'index' => [
	            'show' => 0
            ]
	    ],     
	    'date_created' => [
            'index' => [
	            'show' => 0
            ]
	    ], 
	    'alias' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'keywords' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'description' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'status' => [
            'index' => [
	            'show' => 0
            ]
	    ]
    ];



	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/api/contents/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	    'checkbox_panel' => [
		    'selects' => [ 
		        [			    
                    'id' => 'checkboxPanelSelectPN', 
                    'name' => 'select_share',
                    'label' => 'Действия с выделенным',
                    'options' => [
	                    '/api/contents/markDeletedApi/Api.Contents/' => 'Удалить отмеченное'
                    ],
                    'data-params' => '{ 
	                    "model" : "Api_Contents"
                    }',
                    'data-action' => '{ 
	                    "action" : "Api_Contents.indexHandle"
                    }',
                    'class' => 'on-select__finder',
                    'wrap_class' => 'grid',
                    'escape' => false,
                    'empty' => 'Не выбрано',
                    'type' => 'select'
		        ]
		    ]
		    
	    ]
	];



}
