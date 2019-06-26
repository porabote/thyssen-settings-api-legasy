<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CardsTable extends Table
{

    public function initialize(array $config)
    {

        parent::initialize($config);
        $this->belongsTo('Contractors');

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
	    'number' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ] ] ],
	    'contractor_id' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ] ] ]      
    ];



    public $contain_map = [
		'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'table' => [
	        'name' => [
	         'link' => '/Cards/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/Cards/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить запись <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Cards/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false
			        ]
		        ]  	    
	    ],
	    'links' => [
		    '<a href="">'
	    ]
	];    
    
    
    
}
