<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class AccountsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'systems';
    }

    public function initialize(array $config)
    {
        $this->setTable('systems.accounts');
        
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new'
                ],
                'Orders.completed' => [
                    'completed_at' => 'always'
                ]
            ]
        ]);
        
        $this->belongsToMany('Shared.Plugins', [
	        'joinTable' => 'systems.accounts_plugins'
        ]);
    }


    public $check_list = [
	    'alias' => [
	        'rules' => [
	            'notEmpty',
	            'latinLettersAndNumbers',
	            'isUnique'
	        ]
        ],
	    'email' => [
	        'rules' => [
	            'notEmpty',
	            'email',
	            'isUnique'
	        ]
        ],
	    'name' => [
	        'rules' => [
	            'notEmpty',
	            'cyrillicLetters'
	        ]
        ],
	    'last_name' => [
	        'rules' => [
	            'notEmpty',
	            'cyrillicLetters'
	        ]
        ],
	    'cl_password' => [
	        'rules' => [
	            'notEmpty',
	            'password'
	        ]
        ],                              
	    'confirm_password' => [
	        'rules' => [
	            'notEmpty',
	            'confirmPassword' => [ 'parrent_field' => 'cl_password' ]
	        ]
        ],
	    'access_oferta' => [
	        'rules' => [
	            'isChecked'
	        ]
        ]
                
    ];



    public function beforeSave(\Cake\Event\Event $event, \Cake\ORM\Entity $entity, 
        \ArrayObject $options)
    {
        if(!empty($entity->cl_password)) {
            $hasher = new DefaultPasswordHasher;
            $entity->cl_password = $hasher->hash($entity->cl_password);
        }
        return true;
    }



    
}
