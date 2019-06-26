<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PluginsTable extends Table
{

    public static function defaultConnectionName() {
        return 'api';
    }

    public function initialize(array $config)
    {
        $this->setTable('api.plugins');
        $this->setPrimaryKey('className');        
    }

    public $contain_map = [];

	public $links = [
	    'table' => [ 	    
	    ],
	    'submenu' => [ 
		        'Обновить автоматически <span class="lnr lnr-chart-bars"></span>' => [
			        'link' => '/plugins/updateplugins/',
			        'param' => [ 'className' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Параметры фильтра по умолчанию <span class="drop-menu edit"></span>' => [
			        'link' => '/plugins/setFilterParams/',
			        'param' => [ 'className' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Параметры общего списка <span class="drop-menu edit"></span>' => [
			        'link' => '/plugins/setViewParams/',
			        'param' => [ 'className' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ]  	    
	    ]
	];
    
}