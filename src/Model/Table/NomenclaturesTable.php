<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class NomenclaturesTable extends Table 
    {

   // public $actsAs = array('Tree');

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public function initialize(array $config)
    {
	    
	   // $this->hasOne('Residues', [ 'foreignKey' => 'nmcl_id', 'joinType' => 'CROSS' ]);
	    
        $this->belongsToMany('CustomTypes'); //, ['dependent' => true]
        $this->belongsTo('Brands');

        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id'	        
        ]);

        $this->belongsTo('Units', [
            'className' => 'Units'      
        ]);
      
    }

    public $contain_map = [
	    'brand_id' => [ 'model' => 'Brands', 'alias' => 'brand', 'propertyName' => 'name', 'assoc_type' =>  'belongsTo' ],  
	    'unit_id' => [ 'model' => 'Units', 'alias' => 'unit', 'propertyName' => 'rus_name1', 'assoc_type' =>  'belongsTo' ],
	    'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'propertyName' => 'name', 'assoc_type' =>  'belongsTo' ] 
    ];


	public $links = [
	    'contain' => [],
	    'table' => [
	        'name' => [
	         'link' => '/nomenclatures/fastView/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="lnr lnr-pencil"></span>' => [
	         'link' => '/nomenclatures/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link', 
	             'escape' => false 
	         ]
	        ],
		    'Удалить <span class="lnr lnr-trash">' => [
			    'link' => '/basemaps/deleteRecord/nomenclatures/',
			    'param' => [ 'id' ],
			    'attr' => [ 
			        'class' => 'hide-blok__link sidebar-open', 
			        'escape' => false,
			        'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить номенклатуру?' } }"
			    ]
		    ]		         	    
	    ]
	];


}
