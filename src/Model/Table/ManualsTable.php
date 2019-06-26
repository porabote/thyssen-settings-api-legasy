<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ManualsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }

    public function initialize(array $config)
    {
	    $this->addBehavior('Tree');
        $this->setTable('api.manuals');        
    }

    /* 
	 *  Default validation list Rules
     */
    public $check_list = [
	    'name' => [
	        'rules' => [
	            'notEmpty'
	        ]
        ]      
    ];

    public $contain_map = [];
    public $links = [];
        
}
