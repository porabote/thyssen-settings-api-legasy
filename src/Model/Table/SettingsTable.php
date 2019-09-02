<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SettingsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }


    public function initialize(array $config)
    {
	    $this->setTable('api.settings');
      //  $this->setPrimaryKey('className');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);

    }




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
	    'type' => [
	        'pattern' => '{% if type == "main" %}<b>Главная (main)</b>{% else %}Пользовательская (custom){% endif %}',
            'index' => [
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Тип'
            ]
	    ],
	    'title' => [
            'pattern' => '<span class="strong">{{title}}</span>',
            'index' => [
	            'width' => '250px',
	            'show' => 1
            ]
	    ],
	    'plugin' => [
            'index' => [
	            'width' => '100px',
	            'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Plugins',
	            'url' => '/api/plugins/getFindList/',
				'hide' => 0,
				'default_value' => '',
				'show' => '1',
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'
	        ]
	    ],     
	    'user_id' => [
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Users',
	            'url' => '/users/getFindList/',
				'hide' => 0,
				'default_value' => '',
				'show' => '1',
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'
	        ]
	    ]	    
    ];



	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/settings/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	    'checkbox_panel' => [
		    'primaryKey' => 'id',
		    'selects' => [ 
		        [			    
                    'id' => 'checkboxPanelSelectSettings', 
                    'name' => 'checkbox_actions',
                    'label' => 'Действия с выделенным',
                    'on-events' => '{"change":"Settings|handleIndex"}',
                    'options' => [
	                    '/settings/deleteRecords/' => 'Удалить'
                    ],
                    'data-params' => '{ 
	                    "model" : "Settings"
                    }',
                    'data-action' => '{ 
	                    "action" : "Settings.indexHandle"
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
