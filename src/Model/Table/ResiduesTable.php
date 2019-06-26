<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ResiduesTable extends Table 
{

    /* 
	 *  Default validation list Rules
     */
    public $check_list = [
	    'id' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Номенклатура не выбрана' ] ,
	           // 'onlyNumbers' => [ 'err_msg' => false ] 
	        ]
        ],
	    'nmcl_id' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Номенклатура не выбрана' ] ,
	           // 'onlyNumbers' => [ 'err_msg' => false ] 
	        ]
        ],
        'quantity_in' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Номенклатура не выбрана' ] ,
	            'onlyNumbers' => [ 'err_msg' => 'Только цифры' ] 
	        ]
        ],
        'quantity_out' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Номенклатура не выбрана' ] ,
	            'onlyNumbers' => [ 'err_msg' => 'Только цифры' ] 
	        ]
        ]      
    ];
    
    
    public $contain_map = [
		'nmcl_id' => [ 'model' => 'Nomenclatures', 'alias' => 'nomenclature', 'fields' => '*', 'assoc_type' =>  'belongsTo', 'filter' => true ], 
		'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ],
		'store_id' => [ 'model' => 'Stores', 'alias' => 'store', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
		'company_id' => [ 'model' => 'Companies', 'alias' => 'company', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ],
		'batch_id' => [ 'model' => 'Batches', 'alias' => 'batch', 'fields' => 'number', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'table' => [
	        'name' => [
	         'link' => '/nomenclatures/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Движения <span class="lnr lnr-chart-bars"></span>' => [
	         'link' => '/residues/showMoves/',
	         'param' => [ 'nmcl_id', 'store_id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link', 
	             'data-sidebar' => '{ "server-action" : "/residues/showMoves/", "item-alias" : "addBatchLine" }',
	             'escape' => false 
	            ]
	        ] 	    
	    ],
	    'links' => [
		    '<a href="">'
	    ]
	];


    public function initialize(array $config)
    {

        $this->belongsTo('Nomenclatures', ['foreignKey' => 'nmcl_id']);
        $this->belongsTo('Users');
        $this->belongsTo('Stores');
        $this->belongsTo('Companies');
        $this->belongsTo('Batches');
      //  $this->belongsTo('Parent', [ 'className' => 'residues' ]);
        
        $this->addBehavior('Tree');        
        
        

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated_at' => 'always',
                ],
                'Orders.completed' => [
                    'completed_at' => 'always'
                ]
            ]
        ]);


    }


}
