<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class FilesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->belongsTo('Users'); 
        $this->belongsTo('PurchaseNomenclatures', [
            'foreignKey' => 'record_id',
            'conditions' => [ 'model_alias' => 'PurchaseNomenclatures' ]
        ]);
        $this->belongsTo('PurchaseRequest', [
            'foreignKey' => 'record_id',
            'conditions' => [ 'model_alias' => 'PurchaseRequest' ]	        
        ]);

        $this->addBehavior('CounterCache', [
            'PurchaseNomenclatures' => [
                'files_count' => [
                    'conditions' => ['Files.setting_alias' => 'PurchaseNomenclatures']
                ]
            ],
            'PurchaseRequest' => [
                'files_count' => [
                    'conditions' => ['Files.setting_alias' => 'PurchaseRequest']
                ]
            ]
        ]);
 
    }

    
    
    public $check_list = [
	    //'user_id' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ] ] ]      
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
	    'record_id' => [
            'index' => [
	            'width' => '80px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'ID записи'
            ]
	    ],
	    'uri' => [
		    'pattern' => '<a href="/filesData/getListByParent/{{id}}">{{uri}}</a>',
            'index' => [	            
	            'width' => '300px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Относительный путь'
            ]
	    ],
	    'model_alias' => [
            'index' => [
	            'width' => '130px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Модель'
            ]
	    ],
	    'size' => [
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Размер'
            ]
	    ],
	    'date_created' => [
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Дата доб.'
            ]
	    ],
	    'ext' => [
            'index' => [
	            'width' => '60px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Тип'
            ]
	    ],
	    'width' => [
		    'pattern' => '{{width}}x{{height}}',
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Размер (px)'
            ]
	    ],
	    'height' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'prefix' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'mime' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'main' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'user_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'path' => [
            'index' => [
	            'show' => 0
            ]
	    ],	    
	    'basename' => [
            'index' => [
	            'show' => 0
            ]
	    ],	
	    'data_s_path' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'label' => [
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Метка'
            ]
	    ],
	    'title' => [
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Описание'
            ]
	    ],	    
	    'flag' => [
	        'pattern' => '{% if flag == "on" %}Вкл.{% else %}Выкл.{% endif %}',
            'index' => [
	            'width' => '60px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Статус'
            ]
	    ]

    ];


	public $links = [
	    'table' => [
	        'fio' => [
	         'link' => '/files/add/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/files/add/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить запись <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Files/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false
			        ]
		        ]  	    
	    ],
	    'links' => [
		    '<a href="">'
	    ]
	];    
    
    
    
}
