<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class EmployeesTable extends Table
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
       // $this->setTable('peoples', ['conditions' => ['Users.field = Post.field']]);
        $this->setTable('peoples');

        //$this->belongsTo('Posts');
        $this->hasOne('Users', ['foreignKey' => 'people_id']);
        $this->belongsTo('Contractors');
        $this->belongsTo('Departments');
        
        /*
        $this->belongsTo('Companies', [
	        'className' => 'Contractors',
	        'foreignKey' => 'model_id',
	        'conditions' => [ 'flag' => 'cover', 'model_alias' => 'News' ] 
        ]);
        */
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ]
            ]
        ]);

    }


    public function beforeFind($event, $query, $options, $primary)
    {
        // if ->applyOptions(['default' => false]) not use default conditions
        if(isset($options['default']) && $options['default'] == false){
            return $query;
        }

        //$query->where(['Employees.flag' => 'employe']);
        $query->andWhere(['Employees.contractor_id IS NOT' => NULL]);
    
        //$query->order(['sort' => 'ASC']);
    
        return $query;
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
	    'name' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ]
	        ]
        ]      
    ];



    public $contain_map = [
	    'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ],
	    'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'hasOne' ],
	   // 'post_id' => [ 'model' => 'Posts', 'alias' => 'post', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'table' => [
	        'name' => [
	         'link' => '/peoples/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Корректировка <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/peoples/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false 
			        ]
		        ],
		        'Удалить запись <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Peoples/',
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
