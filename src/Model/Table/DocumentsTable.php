<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;


class DocumentsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    public $check_list = [     
    ];

    public $contain_map = [
    ];

    public $links = [
    ];

}

