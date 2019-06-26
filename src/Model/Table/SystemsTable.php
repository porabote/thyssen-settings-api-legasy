<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SystemsTable extends Table
{

    public static function defaultConnectionName()
    {
      //  return 'systems';
    }


    public function initialize(array $config)
    {
        //$this->setTable('classis.systems');
    }
    
}
