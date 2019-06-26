<?php
namespace App\Model\Table;

use Cake\ORM\Table;


class WorkShemasTable extends Table
{

    public $check_list = [
	    //'name' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
      
    ];

    public $links = [
    ];

    public function initialize(array $config)
    {
        
    }
}
