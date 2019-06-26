<?php
namespace App\Model\Table;

use Cake\ORM\Table;


class BrandsTable extends Table
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
              'Редактировать <span class="lnr lnr-pencil"></span>' => [
      	        'link' => '/Brands/edit/',
      	        'param' => [ 'id' ],
      	        'attr' => [ 
      	            'class' => 'hide-blok__link sidebar-open', 
      	            'escape' => false 
      	        ]
              ],
		        
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Brands/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить бренд?' } }"
			        ]
		        ]   	    
        ]
    ];

    public function initialize(array $config)
    {
        
    }
}
