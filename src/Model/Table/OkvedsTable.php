<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OkvedsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'classis';
    }


    public function initialize(array $config)
    {
        $this->addBehavior('Tree');
        $this->setTable('classis.okveds');
        
    }
    
}
