<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;

class ContractRolesTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }

    public function initialize(array $config)
    {
        $this->setTable('api.contract_roles');

    }

    public $contain_map = [];
    public $links = [];

}
?>
