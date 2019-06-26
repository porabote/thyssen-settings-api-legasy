<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProfilesTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'systems';
    }


    public function initialize(array $config)
    {
        $this->setTable('systems.profiles');


        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new'
                ]
            ]
        ]);
        
    }



    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
	    'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' , 'filter' => true ]
    ];

	public $links = [
	    'table' => [ 	    
	    ],
	    'submenu' => [ 
		        'Редактировать модель <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/profiles/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ]  	    
	    ]
	];



    
}
