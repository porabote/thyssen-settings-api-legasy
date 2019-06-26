<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CompaniesTable extends Table 
    {

    /* 
	 *  Default validation list Rules
     */
    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ],
	    'inn' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,10] ] ] , 
	    'kpp' => [ 'rules' => [ 'onlyNumbers', 'between' => [0,9] ] ] 
    ];

    public function initialize(array $config)
    {
      //  $this->belongsToMany('Products');

        $this->belongsTo('TypesCompanies', ['foreignKey' => 'type_id']);
        $this->belongsTo('Users');
        $this->belongsTo('Cities');
       // $this->belongsTo('Statuses', ['foreignKey' => 'statuse_id']);
        $this->hasOne('Contractors', [
            'foreignKey' => 'record_id',
            'className' => 'Contractors',
            'conditions' => [ 'Contractors.model' => 'Companies']
        ]); 
        $this->hasMany('Stamps', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'label' => 'stamp', 'model_alias' => 'Companies' ]
        ]);       


        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'count_modified' => 'always',
                ]
            ]
        ]);
    }

    public $contain_map = [
	    'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsTo' ],
	    'city_id' => [ 'model' => 'Cities', 'alias' => 'city', 'propertyName' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [
	    'contain' => [],
	    'table' => [
	        'name' => [
	         'link' => '/companies/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
	        'Корректировка <span class="lnr lnr-pencil"></span>' => [
	         'link' => '/companies/edit/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'hide-blok__link', 
	             'escape' => false 
	         ]
	        ],
		    'Удалить <span class="lnr lnr-trash">' => [
			    'link' => '/basemaps/deleteRecord/companies/',
			    'param' => [ 'id' ],
			    'attr' => [ 
			        'class' => 'hide-blok__link sidebar-open', 
			        'escape' => false,
			        'data-sidebar' => "{ 'post_data' : { 'message' : 'Уверены что хотите удалить запись?' } }"
			    ]
		    ]		         	    
	    ]
	];

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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('full_name');


        return $validator;
    }


}
