<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class StoresTable extends Table
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

        $this->setTable('stores');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');


        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Writeoffs', [
            'foreignKey' => 'writeoff_id',
            'joinType' => 'INNER'
        ]);


        $this->hasMany('Residues', [
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);



    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');
/*
        $validator
            ->allowEmpty('number');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('comments', 'create')
            ->notEmpty('comments');
*/
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
       // $rules->add($rules->existsIn(['writeoff_id'], 'Writeoffs'));

        return $rules;
    }
    
    

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Номенклатура не выбрана' ]
	        ]
        ]      
    ];


    public $contain_map = [
	    'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsTo' ],
    ];




	public $links = [
		    'contain' => [],
		    'table' => [
		        'name' => [
			        'link' => '/stores/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'table__link', 
			            'escape' => false 
			        ]
		        ] 	    
		    ],
		    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/stores/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/stores/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить склад?' } }"
			        ]
		        ] 		         	    
		    ]
	    ];    
    
    
    
    
}
