<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContractorsTable extends Table
{

    public function initialize(array $config)
    {

        parent::initialize($config);
        //$this->belongsTo('Contractors');
        $this->belongsTo('Peoples', [ 'foreignKey' => 'p_id' ]);
        $this->belongsTo('Companies', [ 'foreignKey' => 'c_id' ]);
        $this->belongsTo('Entrepreneurs', [ 'foreignKey' => 'e_id' ]);
        
        $this->hasMany('BankAccounts');
        // Генеральный директор
        $this->hasOne('Gd', [
            'foreignKey' => 'contractor_id',
            'className' => 'Posts',
            'joinTable' => 'posts',
            'conditions' => ['Gd.type' => 'gd']
        ]);
        // Главный бухгалтер
        $this->hasOne('Gb', [
            'foreignKey' => 'contractor_id', 
            'className' => 'Posts', 
            'joinTable' => 'posts',
            'conditions' => ['Gb.type' => 'gb']
            ]);        
        // Юридический адрес
        $this->hasOne('AddressLegal', [
            'foreignKey' => 'contractor_id',
            'className' => 'Addresses', 
            'joinTable' => 'addresses',
            'joinType' => 'LEFT',
            'conditions' => ['AddressLegal.type' => 'legal']
        ]);
        // Фактический адрес
        $this->hasOne('AddressActual', [
            'foreignKey' => 'contractor_id',
            'className' => 'Addresses', 
            'joinTable' => 'addresses',
            'joinType' => 'LEFT',
            'conditions' => ['AddressActual.type' => 'actual']
        ]); 
        // Банковские реквизиты
        $this->hasOne('BankAccountDefault', [
            'foreignKey' => 'contractor_id',
            'className' => 'BankAccounts', 
            'joinTable' => 'bank_accounts',
            'joinType' => 'LEFT',
            'conditions' => ['BankAccountDefault.type' => 'default']
        ]);        
        
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
	    'contractor_id' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ] ] ],	    
	    'gd_id' => [ 'model' => 'Gd', 'alias' => 'gd', 'fields' => 'full_name', 'assoc_type' =>  'hasOne' ],
	    'gb_id' => [ 'model' => 'Gb', 'alias' => 'gb', 'fields' => 'full_name', 'assoc_type' =>  'hasOne' ]      
    ];



    public $contain_map = [];


	public $links = [
	/*
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
	    */
	];    
    
    
    
}
