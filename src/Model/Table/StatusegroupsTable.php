<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatusegroupsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'shared';
    }


    public function initialize(array $config)
    {
	    $this->setTable('shared.statusegroups');
	    $this->hasMany('Statuses');
        
    }
    
}
