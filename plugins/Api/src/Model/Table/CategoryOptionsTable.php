<?php
namespace Api\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoryOptionsTable extends Table 
    {


    public function initialize(array $config)
    {


       // $this->table('categoryOptions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->belongsToMany('Categories');

/*
        $this->belongsTo('Users');
        $this->hasMany('Files', [
	        'foreignKey' => 'record_id',
	        'conditions' => [ 'modelmap_alias' => 'categoryOptions' ] 
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);
*/
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
		    'pattern' => '<a href="/api/categoryOptions/view/{{id}}/"><span class="cell-info"><span class="cell-item_describe">{{name}}</span></span></a>',
            'index' => [	            
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Название'
            ]
	    ],
	    'categories' => [
		    'pattern' => '{% for category in categories %} {{category.name}} {% endfor %}',
            'index' => [	            
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Ассоциировано с категориями:'
            ]
	    ]	    
    ];



	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/api/categoryOptions/view/{{record.id}}/',
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
	                    '/api/categoryOptions/markDeletedApi/Api.CategoryOptions/' => 'Удалить отмеченное'
                    ],
                    'data-params' => '{ 
	                    "model" : "Api_CategoryOptions"
                    }',
                    'data-action' => '{ 
	                    "action" : "Api_CategoryOptions.indexHandle"
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
