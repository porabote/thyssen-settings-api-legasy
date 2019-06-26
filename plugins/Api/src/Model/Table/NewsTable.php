<?php
namespace Api\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class NewsTable extends Table 
    {


    public function initialize(array $config)
    {


       // $this->table('news');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users');
        $this->hasMany('Files', [
	        'foreignKey' => 'record_id',
	        'conditions' => [ 'modelmap_alias' => 'News' ] 
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
		    'pattern' => '<a href="/api/news/view/{{id}}/"><span class="cell-info"><span class="cell-item_describe">{{name}}</span></span></a>',
            'index' => [	            
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Заголовок'
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
		    'pattern' => '<a href="/api/news/view/{{id}}/"><span class="cell-info"><span class="cell-item_describe">{{text_short|striptags}}</span></span></a>',
            'index' => [	            
	            'width' => '350px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Краткий текст'
            ]
	    ],
	    'user_id' => [
		    'leftJoin' => 'Users',
		    'pattern' => '<a href="/api/news/view/{{id}}/"><span class="cell-info"><span class="cell-item_describe">{{user.full_name}}</span></span></a>',
            'index' => [	            
	            'width' => '150px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Добавил(а)'
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
		'contain' => [],
		'table' => [
		    'name' => [
		        'link' => '/api/news/view/',
		        'param' => [ 'id' ],
		        'attr' => [ 
		            'class' => 'table__link', 
		            'escape' => false 
		        ]
		    ] 	    
		],
		'submenu' => [ 
		    'Корректировка <span class="lnr lnr-pencil"></span>' => [
		        'link' => '/api/news/view/',
		        'param' => [ 'id' ],
		        'attr' => [ 
		            'class' => 'hide-blok__link', 
		            'escape' => false 
		        ]
		    ],
		    'Удалить <span class="lnr lnr-trash">' => [
		        'link' => '/api/settings/markDeletedApi/Api.News/',
		        'param' => [ 'id' ],
		        'attr' => [ 
		            'class' => 'hide-blok__link sidebar-open', 
		            'escape' => false,
		            'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить страницу?' } }"
		        ]
		    ] 		         	    
		]
	];



}
