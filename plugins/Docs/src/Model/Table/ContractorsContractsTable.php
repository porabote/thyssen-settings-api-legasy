<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;


class ContractorsContractsTable extends Table
{
	
    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    public $contain_map = [];
    public $links = [];
    
}

