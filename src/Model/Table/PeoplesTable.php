<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PeoplesTable extends Table 
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated_at' => 'always',
                ]
            ]
        ]);

        $this->hasOne('Contractors', [
            'foreignKey' => 'record_id',
            'className' => 'Contractors',
        ])->setName('Contractors')->setConditions(['model' => 'Peoples']);

        $this->hasMany('Facsimiles', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'label' => 'facsimile', 'model_alias' => 'Peoples' ]
        ]);

        $this->hasMany('Phones', [
            'foreignKey' => 'record_id',
            'className' => 'Contacts',
            'conditions' => [ 'model_alias' => 'Peoples', 'type' => 'phone', 'flag' => 'on' ]
        ]);

        $this->hasMany('Emails', [
            'foreignKey' => 'record_id',
            'className' => 'Contacts',
            'conditions' => [ 'model_alias' => 'Peoples', 'type' => 'email', 'flag' => 'on' ]
        ]);

        $this->hasMany('Posts');

        $this->hasOne('Users', [
           // 'foreignKey' => 'userdata_id',
           // 'joinType' => 'LEFT'
        ]);
    }

    /* 
	 *  Default validation list Rules
     */
    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty', 
	            'cyrillicLetters'
	        ]
        ],
	    'last_name' => [
	        'rules' => [
	            'notEmpty', 
	            'cyrillicLetters'
	        ]
        ],
	    'fio_sclon' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ],
	    'serie' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,4] ] ] , 
	    'number' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,6] ] ] , 
	    'branch_code' => [ 'rules' => [ 'between' => [0,10] ] ]                       
    ];



    public $contain_map = [
	    'id' => [
            'pattern' => '{{id}}',
            'index' => [
	            'width' => '65px',
	            'show' => 1
            ]
	    ],
	    'name' => [
            'pattern' => '{{last_name}} {{name}} {{middle_name}}',
            'index' => [
	            'width' => '365px',
	            'show' => 1
            ]
	    ],
	    'last_name' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'middle_name' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'serie' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'number' => [
            'index' => [
	            'show' => 0
            ]
	    ],	
	    'adress' => [
            'index' => [
	            'show' => 0
            ]
	    ],		    	        
	    'user_id' => [
            'leftJoin' => 'Users',
            'pattern' => '<span class="post-info"><span class="post-fio">{{user.full_name}}</span></span>',
            'index' => [
	            'width' => '211px',
	            'show' => 1
            ],
	        'filter' => [
	    	    'modelAlias' => 'Users',
	            'url' => '/users/getAjaxList/',
	            'uri' => '{
		            where : {OR : [{"name LIKE" : "%{{value}}%"}, {"last_name LIKE" : "%{{value}}%"}]},
		            pattern : "{{last_name}} {{name}}" 
	            }',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'db_params' => [
              'comment' => 'Прикреплено к пользователю'
            ]
	    ]
    ];


	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/peoples/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	    'checkbox_panel' => [
		    'selects' => [ 
		        [			    
                    'id' => 'checkboxPanelSelectPeoples',
                    'name' => 'parent_id',
                    'data-params' => '{"readonly":true}',
                    'on-events' => '{"change":"Peoples|handleIndex"}',
                    'label' => 'Действия с выделенным',
                    'options' => [
	                    '/peoples/setFlag/?className=Peoples&flag=delete' => 'Скрыть/Пометить к удалению'
                    ],
                    'class' => 'on-select__finder list-listener',
                    'escape' => false,
                    'empty' => 'Не выбрано',
                    'type' => 'select'
		        ]
		    ]
		    
	    ]
	];


}
