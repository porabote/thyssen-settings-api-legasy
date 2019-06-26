<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatusesstagesTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'shared';
    }


    public function initialize(array $config)
    {
	    $this->setTable('shared.statusesstages');
	    $this->hasMany('Statuses');
        
    }
    
}
