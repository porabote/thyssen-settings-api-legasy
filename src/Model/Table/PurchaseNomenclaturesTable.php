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
        
        $this->belongsToMany('Purchases', [
	        'foreignKey' => 'nomenclature_id',
	        'joinTable' => 'nomenclatures_purchases'
        ]);
        
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
        'request_id' => [
            'pattern' => '<u><a href="/purchaseRequest/view/{{request_id}}">{{request_id}}</a></u>',
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
	            'width' => '350px',
	            'show' => 1
            ]
	    ],
	    'quantity' => [
            'pattern' => '{{quantity}} {{unit_name}}',
            'index' => [
	            'width' => '70px',
	            'show' => 1
            ]
	    ],
        'date_purchase' => [
            'pattern' => '{% if date_purchase %}{{date_purchase}}{% endif %}',
            'index' => [
                'width' => '140px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Дата поставки'
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
				'operator_logical' => 'AND'	            
	        ],
	    ],
	    'manager_id' => [
            'leftJoin' => 'Managers',
            'pattern' => '<span class="post-info"><span class="post-fio">{{manager.fio}}</span> <span class="post-name">{{manager.name}}</span></span>',
            'index' => [
	            'width' => '211px',
	            'show' => 1
            ],
	        'filter' => [
	    	    'modelAlias' => 'Managers',
	            'url' => '/posts/getAjaxList/',
	            'uri' => '{
		            where : {OR : [{"name LIKE" : "%{{value}}%"}, {"fio LIKE" : "%{{value}}%"}]},
		            pattern : "{{fio}} - {{name}}" 
	            }',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ]
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
		    'leftJoin' => 'Bills',
            'pattern' => '<u><a href="/store/bills/view/{{bill_id}}/">{{bill.number}}</a></u>',
            'index' => [
	            'width' => '65px',
	            'show' => 1
            ]
	    ],
	    'purchase_id' => [
            'pattern' => '<u><a href="/purchases/view/{{purchase_id}}/">{{purchase_id}}</a></u>',
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
            'pattern' => '<span class="cell-info"><span class="cell-item_title">{{address.contractor.name1}}<span class="cell-item_describe">{{address.full_address}}</span> </span></span> {{purchase_type}}',
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
        'date_to' => [
            'pattern' => '{% if date_to %}{{date_to}}{% endif %}',
            'index' => [
                'width' => '180px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Дата поставки (инициатор)'
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
	    ],
	    'unit_quantity' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'kind' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'name_analog' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'barcode' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'article' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'flag' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'transport_company_id' => [
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
                    'data-params' => '{"readonly":true}',
                    'on-events' => '{"change":"PurchaseNomenclatures|handleIndex"}',
                    'label' => 'Действия с выделенным',
                    'options' => [
	                    '/purchaseNomenclatures/setPurchaseParams/' => 'Указать данные поставки'
                    ],
                    'class' => 'on-select__finder list-listener',
                    'escape' => false,
                    'empty' => 'Не выбрано',
                    'type' => 'select'
		        ]
		    ]
		    
	    ]
	];


}
