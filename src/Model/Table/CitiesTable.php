<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CitiesTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }


    public function initialize(array $config)
    {
        //$this->setTable('api.cities');
        
    }


    public $contain_map = [
    ];

    public $links = [
    ];

    
}
