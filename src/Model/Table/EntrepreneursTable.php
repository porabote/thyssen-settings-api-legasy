<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class EntrepreneursTable extends Table
{
  
  
  public function initialize(array $config)
    {
        $this->belongsTo('Users');
        $this->belongsTo('Cities');
        $this->belongsTo('Taxes'); 
        $this->hasOne('Contractors', [
            'foreignKey' => 'record_id',
            'conditions' => [ 'model' => 'Entrepreneurs'],
            'dependent' => true
        ]);       

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new',
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
        ]              
    ];



    public $contain_map = [
        'id' => [
            'pattern' => '{{id}}',
            'index' => [
                'width' => '70px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => '<span>Номер<br><sup class="grid_list__item sup">ID</sup></span>'
            ]
        ],
        'full_name' => [
            'pattern' => '<a href="/entrepreneurs/view/{{id}}/">{{full_name}}</a>',
            'index' => [
                'width' => '350px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Название'
            ]
        ],
        'inn' => [
            'pattern' => '{{inn}}',
            'index' => [
                'width' => '150px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'ИНН'
            ]
        ],
        'ogrn' => [
            'pattern' => '{{ogrn}}',
            'index' => [
                'width' => '150px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'ОГРН'
            ]
        ]
    ];


	public $links = [
	    'table' => [
	        'number' => [
	         'link' => '/entrepreneurs/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	         'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/Entrepreneurs/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Entrepreneurs/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить запись?' } }"
			        ]
		        ]  	    
	    ],
	    'links' => [
		    '<a href="">'
	    ]
	];



}


