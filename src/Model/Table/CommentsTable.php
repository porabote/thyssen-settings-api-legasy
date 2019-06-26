<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommentsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->belongsTo('Users');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new'
                ]
            ]
        ]);

    }

    
    public $check_list = [
	    'msg' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ] ] ],
	    'user_id' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ] ] ]      
    ];



    public $contain_map = [
		    'user_id' => [ 'model' => 'Plugins', 'alias' => 'plugin', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


	public $links = [];    
    
    
    
}
