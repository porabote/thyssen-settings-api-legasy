<?php
namespace Store\Model\Table;

use Cake\ORM\Table;


class BillsTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('contract_extantions');

        $this->belongsTo('Docs.ContractSets', [
	        'foreignKey' => 'set_id',
        ]);

        $this->belongsTo('Objects', [ 'className' => 'Departments', 'joinTable' => 'departments' ]);
        $this->belongsTo('Contractors', [ 'className' => 'Contractors', 'joinTable' => 'contractors' ]);
        $this->belongsTo('Clients', [ 'className' => 'Contractors', 'joinTable' => 'contractors' ]);
        $this->belongsTo('Managers', [ 'className' => 'Posts', 'joinTable' => 'posts' ]);

        $this->belongsTo('Statuses');

        $this->belongsTo('WhoSignQueue', [
            'foreignKey' => 'who_sign_queue_id',
            'className' => 'Posts',
            'propertyName' => 'who_sign_queue'
        ]);

        $this->hasMany('PurchaseNomenclatures', [
            'foreignKey' => 'bill_id',
            'propertyName' => 'nomenclatures',
            //'conditions' => [ 'PurchaseNomenclatures.parent_id IS NOT' => null ]
        ]);

        $this->hasMany('Payments', [
            'foreignKey' => 'bill_id'
        ]);

        $this->hasMany('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'model_alias' => 'Docs.ContractExtantions', 'flag' => 'on' ]
        ]);

        $this->hasOne('FileOfBill', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'propertyName' => 'file_of_bill',
            'conditions' => [ 'model_alias' => 'Store.Bills', 'Files.flag' => 'on', 'Files.label' => 'bill' ]
        ]);
    }

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ],
	    'last_name' => [ 'rules' => [ 'notEmpty' ] ],
	    'middle_name' => [ 'rules' => [ 'notEmpty' ] ]
    ];

    public $contain_map = [

      'contractor_id' => [
		    'leftJoin' => 'Contractors',
	        'pattern' => '{{contractor.name}} {{contractor.inn}} / {{contractor.kpp}}',
	        'filter' => [
		        'modelName' => 'Contractors',
                'label' => 'Поставщик',
                'elementType' => 'select',
	            'url' => '/contractors/getAjaxList/',
                'uri' => [
                    'where' => [
                        'AND' => [
                            'model IN' => ['Companies', 'Entrepreneurs'],
                            "name LIKE" => '%{{value}}%'
                        ]
                    ]
                ],
				'hidden' => 0,
				'defaultValue' => null,
				'display' => true,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
            ],
	        'index' => [
	            'width' => '212px',
	            'display' => true
            ]
	    ],
	    'number' => [
            'leftJoin' => 'FileOfBill',
            'pattern' => '
                <b>{{number}}</b><br> от {{date|date("d/m/Y")}}<br>          
                {% if file_of_bill is not empty %}
                    <a target="blank" class="grid_list__icon link-arrow-blank left" href="{{file_of_bill.uri}}">Файл счета</a>
                {% endif %}',
            'cell-value' => '{{id}}',
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => 'LIKE',
                'output_type' => 'select',
                'operator_logical' => 'AND'
            ],
            'index' => [
	            'width' => '220px',
	            'display' => true
            ],
            'db_params' => [
                'comment' => 'Номер/Дата'
            ]
	    ],
        'flag' => [
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => 'on',
                'display' => true,
                'operator' => '=',
                //'output_type' => 'select',
                'operator_logical' => 'AND'
            ],
            'index' => [
                'width' => '180px',
                'display' => true
            ],
            'db_params' => [
                'comment' => 'Номер/Дата'
            ]
        ],
	    'date' => [
            'pattern' => '{{date|date("d/m/Y")}}',
            'index' => [
	            'width' => '120px',
	            'show' => 0
            ]
	    ],
	    'status_id' => [
		    'leftJoin' => 'Statuses',
	        'pattern' => '{{status.name}}',
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => '=',
                'output_type' => 'select',
                'operator_logical' => 'AND'
            ],
	        'index' => [
	            'width' => '150px',
	            'display' => true
            ]
	    ],
	    'summa' => [
            'pattern' => '{{summa|number_format(2, \'.\', \' \')}}',//{%  if currency != "RUR" %} {{summa}} EUR {% else %} {{summa}}RUR {% endif; %}
            'index' => [
	            'width' => '120px',
	            'display' => true
            ]
	    ],
        'nds_percent' => [
            'pattern' => '{{nds_percent}} %',
            'label' => 'НДС %',
            'index' => [
                'width' => '120px',
                'display' => true,
                'show' => true,
                'label' => 'НДС %',
            ],
            'db_params' => [
                'comment' => 'НДС %',
            ]
        ],
        'purchase_id' => [
            'leftJoin' => 'Payments',
            'pattern' => '
            {% set remain = 0 %}
            {% set summa_remain = summa %}
            {% set remain_statuses = [50, 56] %}
            
            {% for payment in payments %}
                {% if payment.status_id in remain_statuses %}
                    {% set summa_remain = summa_remain - payment.summa %}
                {% endif %}                                
            {% endfor %}
                <p style="white-space: nowrap;">{{summa_remain|number_format(2, \'.\', \' \')}}</p>
            ',
            'filter' => [
                'label' => 'Остаток',
            ],
            'index' => [
                'width' => '120px',
                'display' => true
            ],
            'db_params' => [
                'comment' => 'Остаток',
            ]
        ],
	    'currency' => [
            'pattern' => '{{currency}}',
            'index' => [
	            'width' => '75px',
	            'display' => true
            ]
	    ],
        'who_sign_queue_id' => [
            'leftJoin' => 'WhoSignQueue',
            'pattern' => '<span class="post-info"><span class="post-fio">{{who_sign_queue.fio}}</span> <span class="post-name">{{who_sign_queue.name}}</span></span>',
            //'cell-value' => '{{who_sign_queue.id}}',
            'filter' => [
                'modelName' => 'Posts',
                'label' => 'На подписи у',
                'elementType' => 'select',
                'url' => '/api-users/getAjaxList/',
                'uri' => [
                    'where' => [
                        'OR' => [
                            'name LIKE' => '%{{value}}%',
                            'post_name LIKE' => '%{{value}}%'
                        ]
                    ],
                    'pattern' => '{{name}} - {{post_name}}'
                ],
                'hidden' => 0,
                'defaultValue' => null,
                'display' => true,
                'operator' => '=',
                'output_type' => 'select',
                'operator_logical' => 'AND'
            ],
            'index' => [
                'width' => '220px',
                'display' => true
            ]
        ],
	    'date_to' => [
            'pattern' => '{{date_to|date("d/m/Y")}}',
            'index' => [
	            'width' => '150px',
	            'display' => true
            ],
            'filter' => [
                'elementType' => 'inputDate',
				'defaultValue' => null,
				'display' => true,
                'operator' => 'BETWEEN',
				'output_type' => 'date_period',
				'operator_logical' => 'AND',
                'fields' => [
                    [
                        'id' => 'datePurchaseFactFrom',
                        'type' => 'date',
                        'name' => '[date_to][from]',
                        'label' => 'В плане оплат с',
                        'class' => 'form-item__date on-filter-item js-form-date',
                        'value' => ''//date('d.m.Y')
                    ],
                    [
                        'id' => 'datePurchaseFactTo',
                        'type' => 'date',
                        'name' => '[date_to][to]',
                        'label' => 'В плане оплат по',
                        'class' => 'form-item__date on-filter-item js-form-date',
                        'value' => ''//date('d.m.Y')
                    ]
                ]
	        ]
	    ],
//	    'pay_plan' => [
//            'pattern' => '{{pay_plan}}',
//            'index' => [
//	            'width' => '110px',
//	            'display' => true
//            ]
//	    ],
	    'pay_plan' => [
            'pattern' => '{{pay_plan}}',
            'index' => [
	            'width' => '110px',
	            'display' => true
            ]
	    ],
        'object_id' => [
	    	'leftJoin' => 'Objects',
	        'pattern' => '{{object.name}}',
	        'filter' => [
	    	    'modelAlias' => 'Departments',
                'label' => 'Объект',
                'elementType' => 'select',
	            'url' => '/departments/getAjaxList/',
	            'uri' => [
	                'where' => [
                        'AND' => [
                            'label' => 'object',
                        ]
                    ]
                ],
                'limit' => false,
	            'readonly' => 'readonly',
				'hidden' => 0,
				'defaultValue' => null,
				'display' => true,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
	              'width' => '150px',
	              'display' => true
            ]
	    ],
        'manager_id' => [
	    	'leftJoin' => 'Managers',
            'pattern' => '<span class="post-info"><span class="post-fio">{{manager.fio}}</span> <span class="post-name">{{manager.name}}</span></span>',
	        'filter' => [
	    	    'modelName' => 'Posts',
                'elementType' => 'select',
                'label' => 'Добавил',
	            'url' => '/api-users/getAjaxList/',
                'uri' => [
                    'where' => [
                        'OR' => [
                            'name LIKE' => '%{{value}}%',
                            'post_name LIKE' => '%{{value}}%'
                        ]
                    ],
                    'pattern' => '{{name}} - {{post_name}}'
                ],
				'hidden' => 0,
				'defaultValue' => null,
				'display' => true,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
	              'width' => '150px',
	              'display' => true
            ]
	    ],
        'id' => [
		    'index' => [
			    'width' => '40px',
                'show' => 0
		    ]
	    ],
	    'client_id' => [
		    'leftJoin' => 'Clients',
	        'pattern' => '{{client.name}}',
	        'filter' => [
		        'modelName' => 'Contractors',
                'elementType' => 'select',
                'label' => 'Заказчик',
	            'url' => '/contractors/getAjaxList/',
                'uri' => [
                    'where' => [
                        'AND' => [
                            'type' => 'self',
                            "name LIKE" => '%{{value}}%'
                        ]
                    ]
                ],
				'hidden' => 0,
				'defaultValue' => null,
				'display' => true,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
                'show' => 0
		    ]
	    ],
	    'name' => [
		    'index' => [
                'show' => 0
		    ],
            'db_params' => [
                'comment' => 'Название'
            ]
	    ],
	    'alias' => [
		    'index' => [
                'show' => 0
		    ],
            'db_params' => [
                'comment' => 'Алиас на латинице'
            ]
	    ],
//	    'purchase_id' => [
//		    'index' => [
//                'show' => 0
//		    ]
//	    ],

    ];

	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/store/bills/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]
	    ]
	];

}
