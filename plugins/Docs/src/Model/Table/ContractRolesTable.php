<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;
 
class ContractRolesTable extends Table
{ 

    public static function defaultConnectionName()
    {
        return 'shared';
    }


    public function initialize(array $config)
    {
        $this->setTable('shared.contract_roles');
        
    }


} 
?>
