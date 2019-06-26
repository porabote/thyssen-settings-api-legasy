<?php
namespace Acl\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PatternsTable extends Table 
    {


    public function initialize(array $config)
    {
	    $this->setTable('aros_acos_patterns');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);
    }



    public $check_list = [
	    'title' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Номенклатура не выбрана' ] ] ]      
    ];


    public $contain_map = [
		//'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ]
    ];




	public $links = [
		    'contain' => [],
		    'table' => [
		        'name' => [
			        'link' => '/acl/patterns/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'table__link', 
			            'escape' => false 
			        ]
		        ] 	    
		    ],
		    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/acl/patterns/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/settings/deleteRecord/Acl.Patterns/',
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
