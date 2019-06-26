<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContactsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    
    
    public $check_list = [
	    //'contractor_id' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ] ] ]      
    ];



    public $contain_map = [];


	public $links = [
	    'table' => [
	        'fio' => [
	         'link' => '/contacts/add/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/contacts/add/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить запись <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Contacts/',
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
