<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PurchasesTable extends Table
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

        $this->setTable('purchases');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');


        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
         //   'joinType' => 'INNER'
        ]);

        $this->belongsTo('Statuses', [
            'foreignKey' => 'statuse_id',
            'propertyName' => 'statuse'
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
        //    'joinType' => 'INNER'
        ]);
        $this->belongsTo('Stores');
        
        $this->hasMany('PurchaseNomenclatures');
        $this->hasMany('Residues')->setDependent(true);
        $this->hasMany('Histories')->setDependent(true);
    }

    public $check_list = [
	    'number' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ]
	        ]
        ]      
    ];

    public $contain_map = [
      'id' => [
            'pattern' => '{{id}}',
            'index' => [
	            'width' => '65px',
	            'show' => 1
            ]
	    ],
	    'summa' => [
            'index' => [
	            'show' => 0
            ]
	    ],
      'order_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'contragent_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'date' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'statuse_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'date_created' => [
            'pattern' => '{{date_created}}',
            'index' => [
	            'width' => '200px',
	            'show' => 1
            ]
	    ],
	    'post_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'store_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'comment' => [
            'pattern' => '{{comment}}',
            'index' => [
	            'width' => '300px',
	            'show' => 1
            ]
	    ]
    ];


	public $links = [
	    'table' => [ 
		    'main' => [
			        'link' => '/purchases/view/',
			        'param' => [ 'id' ],
			        'attr' => [  
			            'escape' => false 
			        ]
		        ]  	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="hide-blok__link__icon edit"></span>' => [
	            'link' => '/purchases/view/',
	            'param' => [ 'id' ],
	            'attr' => [ 
	                'class' => 'hide-blok__link', 
	                'escape' => false 
	            ]
	        ],		        
		    'Удалить <span class="hide-blok__link__icon trash">' => [
			    'link' => '/basemaps/deleteRecord/purchases/',
			    'param' => [ 'id' ],
			    'attr' => [ 
			        'class' => 'hide-blok__link sidebar-open', 
			        'escape' => false,
			        'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить закупку?' } }"
			    ]
		    ]		         	    
	    ]
	];





}
