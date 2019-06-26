<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PatternsTable extends Table 
    {

    public function initialize(array $config)
    {
      
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new'
                ]
            ]
        ]);

        $this->hasMany('Parts');
        $this->belongsTo('Users');

 
    }





    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Поле не должно быть пустым' ] ] ]  
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
		    'pattern' => '<a href="/docs/patterns/edit/{{id}}/"><span class="cell-info"><span class="cell-item_title">{{name}}</span> <span class="cell-item_describe">{{description}}</span></span></a>',
            'index' => [	            
	            'width' => '390px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Название'
            ]
	    ],
	    'flag' => [
	        'pattern' => '{% if flag == "on" %}Активен{% else %}Выключен{% endif %}',
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Статус'
            ]
	    ],
	    'data_s' => [
            'index' => [
	            'show' => 0
            ]
	    ],     
	    'parts_tree' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'head' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'head' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'sign_area' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'tags' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'base' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'number' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'description' => [
            'index' => [
	            'show' => 0
            ]
	    ]	    	    
    ];




	public $links = 
	[
	    'contain' => [],
	    'table' => [
	        'name' => [
	         'link' => '/docs/patterns/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="lnr lnr-pencil"></span>' => [
	         'link' => '/docs/patterns/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link', 
	             'escape' => false 
	         ]
	        ],
	        'Удалить <span class="lnr lnr-trash">' => [
	         'link' => '/basemaps/deleteRecord/Patterns/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link sidebar-open', 
	             'escape' => false,
	             'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить шаблон?' } }"
	         ]
	        ] 		         	    
	    ]
	];


}
