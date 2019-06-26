<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SessionsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'systems';
    }


    public function initialize(array $config)
    {

        $this->setTable('sessions');

     //   $this->setPrimaryKey('NEWNUM');
        
    }
    
}
