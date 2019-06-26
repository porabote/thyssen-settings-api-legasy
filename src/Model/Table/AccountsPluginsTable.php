<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AccountsPluginsTable extends Table
{


    public static function defaultConnectionName()
    {
        return 'systems';
    }

    public function initialize(array $config)
    {
        $this->setTable('systems.accounts');
    }

    
}
