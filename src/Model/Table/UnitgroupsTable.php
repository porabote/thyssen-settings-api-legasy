<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
 
class UnitgroupsTable extends Table 
{ 

    public static function defaultConnectionName()
    {
        return 'classis';
    }

    public function initialize(array $config)
    {
        $this->setTable('classis.unit_group');
        
        $this->hasMany('Units', [
            'foreignKey' => 'class_unit_group_id',
            'sort' => ['Units.name' => 'ASC']
        ]);
    }


} 
?>
