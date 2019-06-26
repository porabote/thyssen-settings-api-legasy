<?php
namespace Api\Model\Table;

use Cake\ORM\Table;

class PatternsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }

    public function initialize(array $config)
    {
        $this->setTable('api.patterns');
      
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
		'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsTo' ]
    ];




	public $links = [
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