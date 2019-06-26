<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;




class CustomTypesTable extends Table
{


    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {

        parent::initialize($config);

        $this->addBehavior('Tree', [ 'level' => 'level' ]);

        //$this->belongsTo('ModelSettings');        

    }

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ]
	        ]
        ]      
    ];



    public $contain_map = [
	    'name' => [
		    'pattern' => '<a href="/customTypes/add/{{id}}/{{setting_alias}}/" class="sidebar-open"><span class="cell-info folder"><span class="cell-item_name">{{name}}</span> <span class="cell-item_describe">{{comment}}</span></span></a>',
            'index' => [
                'width' => '450px'
            ]    
	    ],	    
 	    'comment' => [
            'index' => [
                'show' => 0
            ]    
	    ],	    
 	    'setting_alias' => [
            'index' => [
                'show' => 0
            ]    
	    ]
    ];


	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/customTypes/add/{{record.id}}/{{record.setting_alias}}/',
			    'class' => 'drop-button__hide-blok__link sidebar-open',
			    'check' => false
		    ]		    
	    ],
	    'checkbox_panel' => [
		    'primaryKey' => 'id',
		    'selects' => [ 
		        [			    
                    'id' => 'checkboxPanelSelectСustomTypes', 
                    'name' => 'parent_id',
                    'label' => 'Действия с выделенным',
                    'options' => [
                        '/customTypes/setFlag/' => 'Удалить выделенные'
                    ],
                    'data-params' => '{ 
                        "model" : "СustomTypes"
                    }',
                    'data-action' => '{ 
                        "action" : "СustomTypes.indexHandle"
                    }',
                    'class' => 'on-select__finder',
                    'escape' => false,
                    'empty' => 'Не выбрано',
                    'type' => 'select'
		        ]
            ]
		    
	    ]
	];



}
