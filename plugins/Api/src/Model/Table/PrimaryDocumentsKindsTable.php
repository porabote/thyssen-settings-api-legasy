<?php
namespace Api\Model\Table;

use Cake\ORM\Table;

class PrimaryDocumentsKindsTable extends Table
{

    public static function defaultConnectionName()
    {
        return 'api';
    }


    public function initialize(array $config)
    {
        $this->setTable('api.primary_documents_kinds');
        //$this->setPrimaryKey('alias');
        
    }

    public $check_list = [
    ];

    public $contain_map = [
    ];


	public $links = [
	];
    
}