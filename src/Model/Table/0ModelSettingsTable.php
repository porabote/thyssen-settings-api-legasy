<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ModelSettingsTable extends Table
{


    public function initialize(array $config)
    {
	    $this->setTable('settings');
      //  $this->setPrimaryKey('className');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);

        $this->hasMany('Statuses', [
            'foreignKey' => 'model_alias',
            'bindingKey' => 'className'
           // 'conditions' => [ 'label' => 'stamp', 'modelmap_alias' => 'Companies' ]
        ]);

    }




    public $contain_map = [];

	public $links = [
	    'table' => [ 	    
	    ],
	    'submenu' => [ 
		        'Обновить автоматически <span class="lnr lnr-chart-bars"></span>' => [
			        'link' => '/modelSettings/dropMain/',
			        'param' => [ 'className' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Редактировать модель <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/modelSettings/edit/',
			        'param' => [ 'className' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ]  	    
	    ]
	];




}
