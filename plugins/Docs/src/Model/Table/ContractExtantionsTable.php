<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;

class ContractExtantionsTable extends Table 
{
    public function initialize(array $config)
    {     
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new',
                    'date_modified' => 'always'
                ]
            ]
        ]);
        $this->belongsTo('Docs.ContractSets', [
	        'foreignKey' => 'set_id',
        ]);

        $this->belongsTo('Statuses');

        
        $this->hasMany('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'model_alias' => 'PurchaseRequest', 'flag' => 'on' ]
        ]);


    }

    public $check_list = [
    ];

    public $contain_map = [
    ];

	public $links = [
	    'contain' => [],
	    'table' => [
		    'main' => [
			        'link' => '/docs/contractExtantions/view/',
			        'param' => [ 'id' ],
			        'attr' => [  
			            'escape' => false 
			        ]
		        ] 	    
	    ],
	    'submenu' => [ 
	        'Просмотр <span class="hide-blok__link__icon edit"></span>' => [
	            'link' => '/docs/contractExtantions/view/',
	            'param' => [ 'id' ],
	            'attr' => [ 
	                'class' => 'hide-blok__link', 
	                'escape' => false 
	            ]
	        ],		        
		    'Удалить <span class="hide-blok__link__icon trash">' => [
			    'link' => '/basemaps/deleteRecord/Docs.ContractExtantions/',
			    'param' => [ 'id' ],
			    'attr' => [ 
			        'class' => 'hide-blok__link sidebar-open', 
			        'escape' => false,
			        'data-sidebar' => "{ 'post_data' : { 'message' : 'Удалить документ?' } }"
			    ]
		    ]		         	    
	    ]
	];


}
