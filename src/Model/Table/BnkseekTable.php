<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BnkseekTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }


    public function initialize(array $config)
    {
        $this->setTable('api.bnkseek');
        $this->setPrimaryKey('BIC');
        
    }

    public $contain_map = [];
    public $links = [];

}
