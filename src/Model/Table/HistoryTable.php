<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class HistoryTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('histories');
        
    }
    
}
