<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;

class PrimaryDocumentsPatternsTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('api_default.primary_documents_patterns');        
        $this->belongsTo('Api.PrimaryDocumentsKinds', [
            'foreignKey' => 'kind_id',
            'primaryKey' => 'id'
        ]);
        $this->belongsTo('Users');
        $this->belongsTo('Cities');

       // $this->belongsTo('Statuses', ['foreignKey' => 'statuse_id']);
        $this->hasOne('Contractors', [
            'foreignKey' => 'record_id',
            'className' => 'Contractors',
            'conditions' => [ 'Contractors.model' => 'Companies']
        ]); 
        $this->hasMany('Stamps', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'label' => 'stamp', 'model_alias' => 'Companies' ]
        ]);       


        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
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
        ],
	   // 'inn' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,10] ] ] , 
	   // 'kpp' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,9] ] ] 
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
		    'pattern' => '<a href="/docs/primaryDocumentsPatterns/view/{{id}}/"><span class="cell-info"><span class="cell-item_describe">{{name}}</span></span></a>',
            'index' => [	            
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Название'
            ]
	    ],
	    'orientation' => [
	        'pattern' => '{% if orientation == "L" %}Горизовантально{% else %}Вертикально{% endif %}',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Положение листа'
            ]
	    ],
	    'by_default' => [
	        'pattern' => '{% if by_default %}Да{% else %}Нет{% endif %}',
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'По умолчанию'
            ]
	    ],
	    'template_head' => [
            'index' => [
	            'show' => 0
            ]
	    ],     
	    'template_body' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'template_nomenclatures' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'template_details' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'template_sign_area' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'css' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'config' => [
            'index' => [
	            'show' => 0
            ]
	    ],    	    
	    'kind_id' => [
		    'leftJoin' => 'PrimaryDocumentsKinds',
		    'pattern' => '{{primary_documents_kind.name}}',
            'index' => [	            
	            'width' => '200px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Группа'
            ]
	    ]
    ];



	public $links = [
	    'contain' => [],
	    'table' => [
	        'name' => [
	         'link' => '/docs/primaryDocumentsPatterns/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="lnr lnr-pencil"></span>' => [
	         'link' => '/docs/primaryDocumentsPatterns/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link', 
	             'escape' => false 
	         ]
	        ],
		    'Удалить <span class="lnr lnr-trash">' => [
			    'link' => '/docs/primaryDocumentsPatterns/deleteRecord/Docs.PrimaryDocumentsPatterns/',
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