<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CalendarsTable extends Table 
    {

    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]              
    ];



    public $contain_map = [
	    'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ] 
    ];


	public $links = [
	    'contain' => [],
	    'table' => [
	        'name' => [
	         'link' => '/calendars/view/',
	         'param' => [ 'id' ],
	         'attr' => [ 
	             'class' => 'table__link', 
	             'escape' => false 
	         ]
	        ] 	    
	    ],
	    'submenu' => [ 
		    		         	    
	    ]
	];




    public function initialize(array $config)
    {
            
        $this->belongsTo('Users');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ]
            ]
        ]);


    }


}
