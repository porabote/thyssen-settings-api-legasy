<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UnitsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }

    public function initialize(array $config)
    {
        $this->setTable('api.unit');
      //  $this->setPrimaryKey('number_code');
    }

    public $contain_map = [
    ];

	public $links = [
	];
	
}
