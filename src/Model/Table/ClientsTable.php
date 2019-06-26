<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ClientsTable extends Table
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

        $this->addBehavior('Tree');
    }
    
    
    
    
    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ]
	        ]
        ]      
    ];



    public $contain_map = [
		    'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
		    'card_id' => [ 'model' => 'Cards', 'alias' => 'cards', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
		  //  'employee_id' => [ 'model' => 'Employees', 'alias' => 'employee', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
		  //  'manage_employee_id' => [ 'model' => 'Employees', 'alias' => 'employee', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
		    'account_id' => [ 'model' => 'Accounts', 'alias' => 'accounts', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'table' => [
	        'name' => [
	         'link' => '/Clients/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/Clients/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить запись <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Clients/',
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
