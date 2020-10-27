<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AccountsPluginsTable extends Table
{


    public static function defaultConnectionName()
    {
        return 'api_accounts';
    }

    public function initialize(array $config)
    {
        $this->setTable('api_accounts.accounts_plugins');
    }

    public $contain_map = [];
    public $links = [

    ];
}
