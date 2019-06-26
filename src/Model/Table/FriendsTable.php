<?php
namespace App\Model\Table;

use Cake\ORM\Table;


class FriendsTable extends Table
{

  public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ]      
  ];

  public $contain_map = [];

	public $links = [
	    'table' => [ 	    
	    ],
	    'submenu' => [  	    
	    ]
	];


    public function initialize(array $config)
    {
        //$this->setTable('menus_users');
    }
}
