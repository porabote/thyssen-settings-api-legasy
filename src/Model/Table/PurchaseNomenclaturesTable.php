<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PurchaseNomenclaturesTable extends Table 
{

    public function initialize(array $config)
    {
/*
        $this->addBehavior('CounterCache', [
            'PurchaseRequest' => ['nmcl_count', [
	            'conditions' => ['Files.flag' => 'on']
            ]]
        ]);
*/

        $this->belongsTo('PurchaseRequest', [
            'foreignKey' => 'request_id'	        
        ]);

        $this->belongsTo('Units', [
            'className' => 'Units'      
        ]);

        $this->belongsTo('Managers', [
            'foreignKey' => 'manager_id',
            'className' => 'Posts',
            'propertyName' => 'manager'
        ]); 

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'propertyName' => 'status',
            'className' => 'Statuses',
        ]); 

        $this->belongsTo('Addresses', [
            'foreignKey' => 'transport_company_address_id',
            'propertyName' => 'address'
        ]);

        $this->belongsTo('Store.Bills', [
            'foreignKey' => 'bill_id',
        ]);

        $this->hasMany('CustomTypes');
        
        $this->hasMany('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'model_alias' => 'PurchaseNomenclatures', 'flag' => 'on' ]
        ]);
    }

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
	    'manager_id' => [
            'leftJoin' => 'Managers',
            'pattern' => '<span class="post-info"><span class="post-fio">{{manager.fio}}</span> <span class="post-name">{{manager.name}}</span></span>',
            'index' => [
	            'width' => '211px',
	            'show' => 1
            ],
	        'filter' => [
	    	    'modelName' => 'Managers',
	            'url' => '/posts/getFindList/',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'
	        ]
	    ],
	    'quantity' => [
            'pattern' => '{{quantity}} {{unit_name}}',
            'index' => [
	            'width' => '70px',
	            'show' => 1
            ]
	    ],
	    'request_id' => [
            'pattern' => '<a href="/purchaseRequest/view/{{request_id}}/">{{request_id}}</a>',
            'index' => [
	            'width' => '90px',
	            'show' => 1
            ]
	    ],
	    'id' => [
            'pattern' => '{{id}}',
            'index' => [
	            'width' => '65px',
	            'show' => 1
            ]
	    ],
	    'name' => [
            'pattern' => '<span class="cell-info"><span class="cell-item_title">{{name}}</span> <span class="cell-item_describe">{{text}}</span></span>',
            'index' => [
	            'width' => '290px',
	            'show' => 1
            ]
	    ],
	    'status_id' => [
	        'leftJoin' => 'Statuses',
            'pattern' => '{{status.name}}',
            'index' => [
	            'width' => '160px',
	            'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Statuses',
	            'url' => '/statuses/getFindList/',
	            'where' => [ 'model_alias' => 'App.PurchaseNomenclatures' ],
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'OR'	            
	        ],
	    ],
	    'text' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	     'unit_name' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'bill_id' => [
            'pattern' => '<a href="/store/bills/view/{{bill_id}}/">{{bill.number}}</a>',
            'index' => [
	            'width' => '65px',
	            'show' => 1
            ]
	    ],
	    'purchase_id' => [
            'pattern' => '<a href="/purchases/view/{{purchase_id}}/">{{purchase_id}}</a>',
            'index' => [
	            'width' => '45px',
	            'show' => 1
            ]
	    ], 
	    'custom_specification' => [
            'pattern' => '{{custom_specification}}',
            'index' => [
	            'width' => '160px',
	            'show' => 1
            ]
	    ],
	    'custom_otdel_zakupok' => [
            'pattern' => '{{custom_otdel_zakupok}}',
            'index' => [
	            'width' => '150px',
	            'show' => 1
            ]
	    ],
	    'date_shipment_schedule' => [
            'pattern' => '{{date_shipment_schedule_format}}',
            'index' => [
	            'width' => '170px',
	            'show' => 1
            ]
	    ],
	    'transport_company_address_id' => [
	        'leftJoin' => ['Addresses' => ['Contractors']],
            'pattern' => '<span class="cell-info"><span class="cell-item_title">{{address.contractor.name}}</span> <span class="cell-item_describe">{{address.city}}</span></span>',
            'index' => [
	            'width' => '170px',
	            'show' => 1
            ]
	    ],
	    'date_shipment_fact' => [
            'pattern' => '{{date_shipment_fact_format}}',
            'index' => [
	            'width' => '170px',
	            'show' => 1
            ]
	    ],
	    'shipment_number' => [
            'pattern' => '{{shipment_number}}',
            'index' => [
	            'width' => '170px',
	            'show' => 1
            ]
	    ],
	    'brand_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'contractor_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'id_out' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'custom_type_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'files_count' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'stock' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'price' => [
            'index' => [
	            'show' => 0
            ]
	    ]
    ];

	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/purchaseNomenclatures/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	    'checkbox_panel' => [
		    'selects' => [ 
		        [			    
                    'id' => 'checkboxPanelSelectPN', 
                    'name' => 'parent_id',
                    'label' => 'Действия с выделенным',
                    'options' => [
	                    '/purchaseNomenclatures/setPurchaseParams/' => 'Указать данные поставки'
                    ],
                    'data-params' => '{ 
	                    "model" : "Settings"
                    }',
                    'data-action' => '{ 
	                    "action" : "Settings.indexHandle"
                    }',
                    'class' => 'on-select__finder',
                    'wrap_class' => 'grid',
                    'escape' => false,
                    'empty' => 'Не выбрано',
                    'type' => 'select'
		        ]
		    ]
		    
	    ]
	];


}
