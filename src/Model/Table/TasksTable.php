<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TasksTable extends Table 
    {

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ],
	    'manager_id' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]              
    ];



    public $contain_map = [
	    'initators' => [ 'className' => 'Posts','model' => 'Initators', 'alias' => 'initators', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsToMany', 'comment' => 'Инициаторы'  ],
	    'managers' => [ 'className' => 'Posts','model' => 'Managers', 'alias' => 'managers', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsToMany', 'comment' => 'Исполнители' ],
	    'listeners' => [ 'className' => 'Posts','model' => 'Listeners', 'alias' => 'listeners', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsToMany', 'comment' => 'Наблюдатели' ],
	    'status_id' => [ 'model' => 'Statuses', 'alias' => 'status', 'propertyName' => 'name', 'assoc_type' =>  'belongsTo' ] 
    ];


	public $links = [
	    'table' => [
	        'name' => [
	            'link' => '/tasks/view/',
	            'param' => [ 'id' ],
	            'attr' => [ 
	                'class' => 'table__link', 
	                'escape' => false 
	            ]
	        ] 	    
	    ],
	    'submenu' => [ 
		        'Просмотр' => [
			        'link' => '/tasks/view/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ]  	    
	    ]
	];


    public function initialize(array $config)
    {
        $this->addBehavior('Tree');

        $this->belongsTo('Statuses', [ 'foreignKey' => 'status_id' ]);
        
        $this->belongsToMany('Initators', [
            'className' => 'Posts',
            'targetForeignKey' => 'post_id',
            'conditions' => [ 'PostsTasks.role' => 'initator' ]
        ]);

        $this->belongsToMany('Managers', [
            'className' => 'Posts',
            'targetForeignKey' => 'post_id',
            'conditions' => [ 'PostsTasks.role' => 'manager', 'flag' => 'on' ]
        ]);

        $this->belongsToMany('Listeners', [
            'className' => 'Posts',
            'targetForeignKey' => 'post_id',
            'conditions' => [ 'PostsTasks.role' => 'listener', 'flag' => 'on' ]
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ]
            ]
        ]);


    }


}
