<?php
namespace App\Model\Table;

use App\Model\Entity\Manager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;


class ManagersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        

        $this->belongsTo('Peoples');

    }



    public $check_list = [    
    ];

    public $contain_map = [
	    'people_id' => [ 'model' => 'Peoples', 'alias' => 'people', 'fields' => 'full_name', 'assoc_type' =>  'belongsTo' ],
	    'group_id' => [ 'model' => 'Groups', 'alias' => 'group', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];

	public $links = [
	    'table' => [ 	    
	    ],
	    'submenu' => [ 
		        'Редактировать модель <span class="lnr lnr-pencil"></span>' => [
			        'link' => '/users/edit/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link', 
			            'escape' => false 
			        ]
		        ]  	    
	    ]
	];



}
