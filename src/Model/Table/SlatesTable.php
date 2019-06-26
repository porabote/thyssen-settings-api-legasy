<?php
namespace App\Model\Table;

use Cake\ORM\Table;


class SlatesTable extends Table
{
  
    public function initialize(array $config)
    {
         $this->belongsTo('Classis.Currencies');
    }

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
      
      'currency_id' => [ 'model' => 'Classis.Currencies', 'alias' => 'currency', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
      
    ];

    public $links = [
        'table' => [ 	    
        ],
        'submenu' => [ 
              'Редактировать <span class="lnr lnr-pencil"></span>' => [
      	        'link' => '/Slates/edit/',
      	        'param' => [ 'id' ],
      	        'attr' => [ 
      	            'class' => 'hide-blok__link sidebar-open', 
      	            'escape' => false 
      	        ]
              ],
		        
		        'Удалить <span class="lnr lnr-trash">' => [
			        'link' => '/basemaps/deleteRecord/Slates/',
			        'param' => [ 'id' ],
			        'attr' => [ 
			            'class' => 'hide-blok__link sidebar-open', 
			            'escape' => false,
			            'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить запись?' } }"
			        ]
		        ]   	    
        ]
    ];

    

    
}
