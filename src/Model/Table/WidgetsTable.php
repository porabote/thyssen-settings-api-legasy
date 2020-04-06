<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class WidgetsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    public $check_list = [
	    'namespace' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
	    'id' => [
            'index' => [	            
	            'width' => '50px',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'ID'
            ]
	    ],
	    'description' => [
            'pattern' => '{{description}}',
            'index' => [
	            'width' => 'minmax(200px, 1fr)',
	            'show' => 1
            ],
            'db_params' => [
	            'comment' => 'Название'
            ]
	    ]	    
    ];

	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/widgets/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	];



}
