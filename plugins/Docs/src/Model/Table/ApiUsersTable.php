<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ApiUsersTable extends Table 
    {

    public static function defaultConnectionName()
    {
        return 'api';
    }

    public function initialize(array $config)
    {
      
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new'
                ]
            ]
        ]);
 
    }





    public $check_list = [
	//    'name' => [ 'rules' => [ 'notEmpty' => [ 'err_msg' => 'Поле не должно быть пустым' ] ] ]  
    ];


    public $contain_map = [
	//	'user_id' => [ 'model' => 'Users', 'alias' => 'user', 'propertyName' => 'full_name', 'assoc_type' =>  'belongsTo' ]
    ];




	public $links = 
	[
	];


}
