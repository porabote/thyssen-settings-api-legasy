<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;


class MenusUsersTable extends Table
{
    public static function defaultConnectionName()
    {
        return 'default';
    }

    public function initialize(array $config)
    {
        $this->setTable('menus_users');
    }
}
