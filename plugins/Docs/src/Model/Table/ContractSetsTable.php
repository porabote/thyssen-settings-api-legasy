<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;


class ContractSetsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);
        
        $this->belongsTo('Contracts');
/*
        $this->belongsTo('Cities');
        $this->belongsTo('Patterns');
        $this->belongsTo('Users');
      
        $this->belongsTo('CustomTypes', [
            'foreignKey' => 'type_id'
        ]);
*/
    }
    
/*
    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ],
	    'pattern_id' => [ 'rules' => [ 'notEmpty' ] ],
	    'city_id' => [ 'rules' => [ 'notEmpty' ] ],
	    'summa' => [ 'rules' => [ 'notEmpty' ] ],
	    'number' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
      'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ],
      'city_id' => [ 'model' => 'Cities', 'alias' => 'city', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
      'pattern_id' => [ 'model' => 'Patterns', 'alias' => 'pattern', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
      'type_id' => [ 'model' => 'CustomTypes', 'alias' => 'type', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
     // 'set_id' => [ 'model' => 'ContractSets', 'alias' => 'set', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
     // 'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractors', 'fields' => 'name', 'assoc_type' =>  'belongsToMany' ]
    ];


*/

    public $contain_map = [
      'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ],
      'city_id' => [ 'model' => 'Cities', 'alias' => 'city', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
      'pattern_id' => [ 'model' => 'Patterns', 'alias' => 'pattern', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
      'type_id' => [ 'model' => 'CustomTypes', 'alias' => 'type', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
     // 'set_id' => [ 'model' => 'ContractSets', 'alias' => 'set', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
     // 'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractors', 'fields' => 'name', 'assoc_type' =>  'belongsToMany' ]
    ];

    public $links = [
        'table' => [ 	    
        ],
        'submenu' => [ 
              'Редактировать <span class="lnr lnr-pencil"></span>' => [
      	        'link' => '/docs/contracts/edit/',
      	        'param' => [ 'id' ],
      	        'attr' => [ 
      	            'class' => 'hide-blok__link', 
      	            'escape' => false 
      	        ]
              ],
		        
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Contracts/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить документ?' } }"
			        ]
		        ]   	    
        ]
    ];

}

