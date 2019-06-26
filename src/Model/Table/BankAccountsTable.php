<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BankAccountsTable extends Table 
    {
      
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new'
                ]
            ]
        ]);
    }

    public $check_list = [
	    'NEWNUM' => [
	        'rules' => [
	            'notEmpty', 
	            'onlyNumbers'
	        ]
        ],
	    'RS' => [
	        'rules' => [
	            'notEmpty', 
	            'onlyNumbers'
	        ]
        ]                        
    ];


    public $contain_map = [];
    public $list = [];
	public $links = [
	    'table' => [
	        'name' => [
	         'link' => '/bankAccounts/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/bankAccounts/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить запись <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/BankAccounts/',
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
