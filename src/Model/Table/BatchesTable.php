<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BatchesTable extends Table
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

        $this->setTable('batches');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');


        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id'
        ]);

        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id',
         //   'joinType' => 'INNER'
        ]);

        $this->belongsTo('Statuses', [
            'foreignKey' => 'statuse_id',
            'propertyName' => 'statuse'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        //    'joinType' => 'INNER'
        ]);
        $this->belongsTo('Stores');
        
        $this->hasMany('Residues')->setDependent(true);
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
/*
        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->integer('balance')
            ->requirePresence('balance', 'create')
            ->notEmpty('balance');

        $validator
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');
*/
        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->allowEmpty('datas');
/*
        $validator
            ->requirePresence('token', 'create')
            ->notEmpty('token');
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
       // $rules->add($rules->existsIn(['order_id'], 'Orders'));
       // $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
    
    
    
    
    public $check_list = [
	    'number' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ]
	        ]
        ]      
    ];



    public $contain_map = [
		'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ],
		'statuse_id' => [ 'model' => 'Statuses', 'alias' => 'statuse', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
		'store_id' => [ 'model' => 'Stores', 'alias' => 'store', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
		'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];

	public $links = [
		    'contain' => [],
		    'table' => [
		        'name' => [
			        'link' => '/contents/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'table__link', 
			            'escape' => false 
			        ]
		        ] 	    
		    ],
		    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/batches/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/App.Contents/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить страницу?' } }"
			        ]
		        ] 		         	    
		    ]
	    ];

	public $list = [
	    'table' => [
	        'number' => [
	         'link' => '/batches/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Смотреть/Добавить товар <span class="lnr lnr-chart-bars"></span>' => [
			        'link' => '/Batches/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'data-sidebar' => '{ "server-action" : "/residues/showMoves/", "item-alias" : "addBatchesLine" }',
			            'escape' => false 
			        ]
		        ], 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/Batches/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Batches/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Все связанные записи о поступлениях и списаниях товаров и материалов будут удалены. Уверены что хотите удалить закупку?' } }"
			        ]
		        ]  	    
	    ],
	    'links' => [
		    
	    ]
	];    
    
    
    
    
    
    
}
