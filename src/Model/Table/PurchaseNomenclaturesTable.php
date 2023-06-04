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

        $this->belongsTo('Objects', [
            //'foreignKey' => 'bill_id',
        ]);

        $this->hasMany('CustomTypes');

        $this->belongsToMany('Purchases', [
            'foreignKey' => 'nomenclature_id',
            'joinTable' => 'nomenclatures_purchases'
        ]);

        $this->hasMany('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => ['model_alias' => 'PurchaseNomenclatures', 'flag' => 'on']
        ]);
    }

    public $check_list = [
        'name' => ['rules' => ['notEmpty']]
    ];

    public $contain_map = [
        'request_id' => [
            'pattern' => '<u><a href="/purchaseRequest/view/{{request_id}}">{{request_id}}</a></u>',
            'index' => [
                'width' => '90px',
                'display' => true
            ],
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => '=',
                'operator_logical' => 'OR'
            ]
        ],
        'id' => [
            'pattern' => '{{id}}',
            'index' => [
                'width' => '65px',
                'display' => true
            ]
        ],
        'name' => [
            'pattern' => '<span class="cell-info"><span class="cell-item_title">{{name}}</span> <span class="cell-item_describe">{{text}}</span></span>',
            'index' => [
                'width' => '350px',
                'display' => true
            ],
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => 'LIKE',
                'operator_logical' => 'OR'
            ]
        ],
        'quantity' => [
            'pattern' => '{{quantity}} {{unit_name}}',
            'index' => [
                'width' => '70px',
                'display' => true
            ]
        ],
        'date_purchase' => [
            'pattern' => '{% if date_purchase %}{{date_purchase}}{% endif %}',
            'index' => [
                'width' => '140px',
                'display' => true
            ],
            'db_params' => [
                'comment' => 'Дата поставки'
            ]
        ],
        'object_id' => [
            'leftJoin' => 'Objects',
            'pattern' => '{{object.name}}',
            'index' => [
                'width' => '150px',
                'show' => 0
            ],
            'filter' => [
                'elementType' => 'select',
                'label' => 'Обьект',
                'modelName' => 'Departments',
                'url' => '/departments/getAjaxList/',
                'hide' => 0,
                'default_value' => null,
                'show' => 1,
                'display' => true,
                'operator' => '=',
                'operator_logical' => 'AND',
                'output_type' => 'select',
                'uri' => [
                    'where' => [
                        'AND' => [
                            'label' => 'object'
                        ]
                    ]
                ]
            ]
        ],
        'status_id' => [
            'leftJoin' => 'Statuses',
            'pattern' => '{{status.name}}',
            'filter' => [
                'elementType' => 'select',
                'label' => 'Статус',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => '=',
                'operator_logical' => 'AND',
                'url' => '/statuses/getAjaxList/',
                'uri' => [
                    'where' => [
                        'AND' => [
                            'model_alias' => 'App.PurchaseNomenclatures'
                        ]
                    ]
                ]
            ],
            'index' => [
                'width' => '160px',
                'display' => true
            ]
        ],
        'manager_id' => [
            'leftJoin' => 'Managers',
            'pattern' => '<span class="post-info"><span class="post-fio">{{manager.fio}}</span> <span class="post-name">{{manager.name}}</span></span>',
            'index' => [
                'width' => '211px',
                'display' => true
            ],
            'filter' => [
                'elementType' => 'select',
                'hidden' => true,
                'label' => 'Ответственный',
                'defaultValue' => null,
                'display' => true,
                'operator' => '=',
                'operator_logical' => 'AND',
                'url' => '/api-users/getAjaxList/',
                'uri' => [
                    'where' => [
                        'OR' => [
                            'name LIKE' => '%{{value}}%',
                            'post_name LIKE' => '%{{value}}%'
                        ]
                    ],
                    'pattern' => '{{name}} - {{post_name}}'
                ]
            ]
        ],
        'text' => [
            'index' => [
                'display' => false
            ],
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => 'LIKE',
                'operator_logical' => 'OR'
            ]
        ],
        'unit_name' => [
            'index' => [
                'display' => false
            ]
        ],
        'bill_id' => [
            'leftJoin' => 'Bills',
            'pattern' => '<u><a href="/store/bills/view/{{bill_id}}/">{{bill.number}}</a></u>',
            'index' => [
                'width' => '65px',
                'display' => true
            ]
        ],
        'purchase_id' => [
            'pattern' => '<u><a href="/purchases/view/{{purchase_id}}/">{{purchase_id}}</a></u>',
            'index' => [
                'width' => '45px',
                'display' => true
            ]
        ],
        'custom_specification' => [
            'pattern' => '{{custom_specification}}',
            'index' => [
                'width' => '160px',
                'display' => true
            ],
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => 'LIKE',
                'operator_logical' => 'OR'
            ]
        ],
        'custom_otdel_zakupok' => [
            'pattern' => '{{custom_otdel_zakupok}}',
            'index' => [
                'width' => '150px',
                'display' => true
            ]
        ],
        'date_shipment_schedule' => [
            'pattern' => '{{date_shipment_schedule_format}}',
            'index' => [
                'width' => '170px',
                'display' => true
            ]
        ],
        'transport_company_address_id' => [
            'leftJoin' => ['Addresses' => ['Contractors']],
            'pattern' => '<span class="cell-info"><span class="cell-item_title">{{address.contractor.name1}}<span class="cell-item_describe">{{address.full_address}}</span> </span></span> {{purchase_type}}',
            'index' => [
                'width' => '170px',
                'display' => true
            ]
        ],
        'date_shipment_fact' => [
            'pattern' => '{{date_shipment_fact_format}}',
            'index' => [
                'width' => '170px',
                'display' => true
            ]
        ],
        'shipment_number' => [
            'pattern' => '{{shipment_number}}',
            'index' => [
                'width' => '170px',
                'display' => true
            ],
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => 'LIKE',
                'operator_logical' => 'OR'
            ]
        ],
        'date_to' => [
            'pattern' => '{% if date_to %}{{date_to}}{% endif %}',
            'index' => [
                'width' => '180px',
                'display' => true
            ],
            'db_params' => [
                'comment' => 'Дата поставки (инициатор)'
            ]
        ],

        'brand_id' => [
            'index' => [
                'display' => false
            ]
        ],
        'contractor_id' => [
            'index' => [
                'display' => false
            ]
        ],
        'id_out' => [
            'index' => [
                'display' => false
            ]
        ],
        'custom_type_id' => [
            'index' => [
                'display' => false
            ]
        ],
        'files_count' => [
            'index' => [
                'display' => false
            ]
        ],
        'stock' => [
            'index' => [
                'display' => false
            ]
        ],
        'price' => [
            'index' => [
                'display' => false
            ]
        ],
        'unit_quantity' => [
            'index' => [
                'display' => false
            ]
        ],
        'kind' => [
            'index' => [
                'display' => false
            ]
        ],
        'name_analog' => [
            'index' => [
                'display' => false
            ]
        ],
        'barcode' => [
            'index' => [
                'display' => false
            ]
        ],
        'article' => [
            'index' => [
                'display' => false
            ]
        ],
        'flag' => [
            'index' => [
                'display' => false
            ]
        ],
        'transport_company_id' => [
            'index' => [
                'display' => false
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
