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
	    'id' => [
	        'pattern' => '{{id}}',
	        'index' => [
		        'width' => '70px',
		        'show' => 1
	        ],
            'db_params' => [
              'comment' => '<span>Номер<br><sup class="grid_list__item sup">ID</sup></span>'
            ]
	    ],
	    'full_name' => [
            'pattern' => '<a href="/companies/view/{{id}}/">{{full_name}}</a>',
	        'index' => [
		        'width' => '350px',
		        'show' => 1
	        ],
            'db_params' => [
              'comment' => 'Название'
            ]
	    ],
	    'inn' => [
            'pattern' => '{{inn}}',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ],
            'db_params' => [
              'comment' => 'ИНН'
            ]
	    ],
	    'ogrn' => [
            'pattern' => '{{ogrn}}',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ],
            'db_params' => [
              'comment' => 'ОГРН'
            ]
	    ],
	    'kpp' => [
            'pattern' => '{{kpp}}',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ],
            'db_params' => [
              'comment' => 'КПП'
            ]
	    ]	    
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
