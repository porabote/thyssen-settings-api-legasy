<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;


class UsersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        //$this->addBehavior('Security.Acl', ['type' => 'requester']);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'count_modified' => 'always',
                    'modified' => 'always',
                ],
                'Orders.completed' => [
                    'completed_at' => 'always'
                ]
            ]
        ]);

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            //'joinType' => 'INNER'
        ]);
        

        $this->belongsTo('Peoples');
        $this->belongsTo('Posts');
        

       // $this->belongsToMany('Menus', ['through' => 'MenusUsers']);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
/*
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('username');

        $validator
            ->allowEmpty('password');

        $validator
            ->allowEmpty('role');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        return $validator;
    }


    public function validationUpdatePassword(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('id')
            // you might want to add some actual password validation here
            ->requirePresence('password')
            ->notEmpty('password');
    
        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));
        return $rules;
    }

*/

    public function beforeSave(\Cake\Event\Event $event, \Cake\ORM\Entity $entity, \ArrayObject $options)
    {
        if(!empty($entity->password)) {
	        
	        if(mb_strlen($entity->password) < 30) {	        
                $hasher = new DefaultPasswordHasher;
                $entity->password = $hasher->hash($entity->password);
            }
        }
        return true;
    }


    public $check_list = [
	    'username' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
	    'id' => [
            'index' => [	            
	            'width' => '50px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'ID'
            ]
	    ],
	    'name' => [
            'pattern' => '<span class="post-info"><span class="post-fio">{{last_name}} {{name}}</span> <span class="post-name">{% if role_id == "1" %}Администратор системы</b>{% else %}Обычный пользователь{% endif %}</span></span>',
            'index' => [
	            'width' => '250px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'ФИО'
            ]
	    ],
	    'last_name' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'people_id' => [
            'leftJoin' => 'Peoples',
            'pattern' => '<span class="post-info"><span class="post-fio">{{people.full_name}}</span></span>',
            'index' => [
	            'width' => '211px',
	            'show' => 1
            ],
	    ],
	    'post_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'people_id' => [
            'leftJoin' => 'Peoples',
            'pattern' => '<span class="post-info"><span class="post-fio">{{people.full_name}}</span></span>',
            'index' => [
	            'width' => '211px',
	            'show' => 1
            ],
	    ],
	    'role_id' => [
		    'pattern' => '{% if role_id == "1" %}<b>Администратор системы</b>{% else %}Обычный пользователь{% endif %}',
            'index' => [
	            'width' => '200px',
	            'show' => 0
            ],
/*
	        'filter' => [
		        'modelName' => 'Roles',
	            'url' => '/roles/getFindList/',
				'hide' => 0,
				'default_value' => '',
				'show' => '1',
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'
	        ]
*/
	    ],
 	    'username' => [
            'pattern' => '<span class="strong">{{username}}</span>',
            'index' => [
	            'width' => '200px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Логин'
            ]
	    ],	    	    
 	    'created' => [
            'pattern' => '<span class="strong">{{created}}</span>',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Дата добавления'
            ]
	    ]	    
    ];

	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/users/edit/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	];



}
