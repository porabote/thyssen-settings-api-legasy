<?php
namespace App\Model\Table;

use Cake\ORM\Table;


class NomenclaturesKindsTable extends Table
{

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
      
    ];

    public $links = [
        'table' => [ 	    
        ],
        'submenu' => [ 
              'Редактировать модель <span class="lnr lnr-pencil"></span>' => [
      	        'link' => '/NomenclaturesKinds/edit/',
      	        'param' => [ 'id' ],
      	        'attr' => [ 
      	            'class' => 'hide-blok__link sidebar-open', 
      	            'escape' => false 
      	        ]
              ],
		        
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/NomenclaturesKinds/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить вид номенклатуры?' } }"
			        ]
		        ]   	    
        ]
    ];

    public function initialize(array $config)
    {
        $this->addBehavior('Tree');
    }
}
