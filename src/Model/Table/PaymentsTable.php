<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Component\HistoryComponent;
use Cake\Http\Session;
use App\Model\Table\Router;

class PaymentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Store.Bills');
        $this->belongsTo('Posts');
        $this->belongsTo('Objects', [ 'className' => 'Departments', 'joinTable' => 'departments' ]);
        $this->belongsTo('Statuses', [
	        'conditions' => [ 'Statuses.model_alias' => 'App.Payments' ]
        ]);

        $this->belongsTo('Contractors');
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'className' => 'Contractors'
        ]);
        $this->belongsTo('Objects', [ 'className' => 'Departments', 'joinTable' => 'departments' ]);

        $this->belongsTo('Creator', [
            'foreignKey' => 'user_id',
            'className' => 'Posts',
            'propertyName' => 'creator'
        ]);


        $this->hasOne('Files', [
            'foreignKey' => 'record_id',
            'className' => 'Files',
            'conditions' => [ 'model_alias' => 'App.Payments', 'flag' => 'on' ]
        ]);


        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new'
                ]
            ]
        ]);

    }

    public $check_list = [
        'summa' => [
            'rules' => [
                'notEmpty'
            ]
        ]
    ];

    public $contain_map = [
        'id' => [
            'leftJoin' => ['Bills' => ['FileOfBill']],
            'pattern' => '
                <a href="/payments/view/{{id}}/">{{id}}</a>
                {% if bill.file_of_bill %}
                  <a class="grid_list__icon link-arrow-blank left" target="blank" href="/payments/getScansAsPdf/{{id}}/">Скан PDF</a>
                {% endif %}  
            ',
            'index' => [
                'width' => '90px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Номер<br><sup class="grid_list__item sup">ID</sup></span>'
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
                'operator_logical' => 'AND'
            ],
            'index' => [
                'width' => '150px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Статус<br><sup class="grid_list__item sup">Status</sup></span>'
            ]
        ],
        'data_json' => [
            'pattern' => '
            {% for psp in data_json.info %}
                <p style="white-space: nowrap;">{{psp.summa|number_format(2, \'.\', \' \')}} | {{psp.psp}}</p>
            {% endfor %}
            ',
            'index' => [
                'width' => '200px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>PSP</span>'
            ]
        ],
        'object_id' => [
            'leftJoin' => 'Objects',
            'pattern' => '{{object.name}}',
            'filter' => [
                'label' => 'Объект',
                'elementType' => 'select',
                'modelAlias' => 'Departments',
                'url' => '/departments/getAjaxList/',
                'uri' => [
                    'where' => [
                        'AND' => [
                            'label' => 'object'
                        ]
                    ]
                ],
                'limit' => false,
                'readonly' => 'readonly',
                'hide' => 0,
                'default_value' => null,
                'display' => true,
                'operator' => '=',
                'output_type' => 'select',
                'operator_logical' => 'AND'
            ],
            'index' => [
                'width' => '100px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Обьект<br><sup class="grid_list__item sup">Object</sup></span>'
            ]
        ],
        'client_id' => [
            'leftJoin' => 'Clients',
            'pattern' => '{{client.name}}',
            'filter' => [
                'modelName' => 'Clients',
                'label' => 'Плательщик',
                'elementType' => 'select',
                'url' => '/contractors/getAjaxList/',
                'uri' => [
                    'where' => [
                        'AND' => [
                            'type' => 'self',
                           // "name LIKE" => '%{{value}}%'
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
                'width' => '280px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Плательщик<br><sup class="grid_list__item sup">Client</sup></span>'
            ]
        ],
        'contractor_id' => [
            'leftJoin' => 'Contractors',
            'pattern' => '{{contractor.name}}',
            'filter' => [
                'modelName' => 'Contractors',
                'label' => 'Поставщик',
                'elementType' => 'select',
                'url' => '/contractors/getAjaxList/',
                'uri' => [
                    'where' => [
                        'AND' => [
                            'model IN' => ['Companies', 'Entrepreneurs'],
                            //'type' => 'client',
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
                'width' => '280px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Контрагент<br><sup class="grid_list__item sup">Contractor</sup></span>'
            ]
        ],
        'bill_id' => [
            'leftJoin' => ['Bills' => ['FileOfBill']],
            'pattern' => '<span style="display: block;">
                <a href="/store/bills/view/{{bill.id}}"><b>{{bill.number}}</b></a>
                <br/> от {{bill.date|date("d/m/Y")}}
            </span>',
            'index' => [
                'width' => '150px',
                'display' => true
            ],
            'filter' => [
                'modelName' => 'Contractors',
                'url' => '/contractors/getAjaxList/',
                'uri' => [
                    'where' => ['model IN' => ['Companies', 'Entrepreneurs'], 'type' => 'client']
                ],
                'hide' => 0,
                'default_value' => null,
                'display' => 0,
                'output_type' => 'select',
                'operator' => '='
            ],
            'db_params' => [
                'comment' => '<span>Счет (номер - дата)<br><sup class="grid_list__item sup">Bill (Nummer - Date)</sup></span>'
            ]
        ],
        'summa' => [
            'pattern' => '{{summa|number_format(2,\'.\',\',\')}} {{currency}}',
            'index' => [
                'width' => '120px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Сумма<br><sup class="grid_list__item sup">Summa</sup></span>'
            ]
        ],
        'percent_of_bill' => [
            'pattern' => '{{percent_of_bill}}',
            'index' => [
                'width' => '120px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Процент оплаты %<br><sup class="grid_list__item sup"></sup></span>'
            ]
        ],
        'rate_euro' => [
            'pattern' => '{% if currency == "RUR" and rate_euro %}{{ (summa / rate_euro)|number_format(2,\'.\',\',\') }} 
                          {% elseif currency == "EUR" %} {{summa|number_format(2,\'.\',\',\')}} 
                          {% else %} -
                          {% endif %}',
            'index' => [
                'width' => '120px',
                'display' => false
            ],
            'db_params' => [
                'comment' => '<span>Сумма (ЕВРО)<br><sup class="grid_list__item sup">Betrag (EUR)</sup></span>'
            ]
        ],
        'date_payment' => [
            'pattern' => '<span class="word-break">{{date_payment|date("d/m/Y")}} ({{pay_week}})</span>',
            'index' => [
                'width' => '140px',
                'display' => true
            ],
            'filter' => [
                'elementType' => 'inputDate',
                'default_value' => null,
                'display' => true,
                'operator' => 'BETWEEN',
                'output_type' => 'date_period',
                'operator_logical' => 'AND',
                'fields' => [
                    [
                        'id' => 'datePurchaseFactFrom',
                        'type' => 'date',
                        'name' => '[date_payment][from]',
                        'label' => 'В плане оплат с',
                        'class' => 'form-item__date on-filter-item js-form-date',
                        'value' => ''//date('d.m.Y')
                    ],
                    [
                        'id' => 'datePurchaseFactTo',
                        'type' => 'date',
                        'name' => '[date_payment][to]',
                        'label' => 'В плане оплат по',
                        'class' => 'form-item__date on-filter-item js-form-date',
                        'value' => ''//date('d.m.Y')
                    ]
                ]
            ],
            'db_params' => [
                'comment' => '<span>День оплаты<br><sup class="grid_list__item sup">Date of payment</sup></span>'
            ]
        ],
        'pay_type' => [
            'pattern' => '{{pay_type}}',
            'index' => [
                'width' => '100px',
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Вид оплаты<sup class="grid_list__item sup">Type of payment</sup></span>'
            ]
        ],
        'pay_object' => [
            'pattern' => '{{pay_object}}',
            'index' => [
                'width' => '100px',
                'display' => false
            ],
            'db_params' => [
                'comment' => '<span>Объект платежа<sup class="grid_list__item sup">Object of payment</sup></span>'
            ]
        ],
        'bill_number' => [
            'leftJoin' => 'Statuses',
            'pattern' => '{{number}}',
            'filter' => [
                'elementType' => 'input',
                'hidden' => true,
                'defaultValue' => null,
                'display' => true,
                'operator' => 'LIKE',
                'operator_logical' => 'AND'
            ],
            'view' => [
                'display' => false
            ],
            'index' => [
                'width' => '150px',
                'display' => false
            ]
        ],
	    'bill_comment' => [
	        'pattern' => '<span class="word-break">{{bill.comment}}</span>',
	        'index' => [
		        'width' => '200px',
		        'display' => true
            ],
            'db_params' => [
              'comment' => '<span>Предмет счёта<br><sup class="grid_list__item sup">Gegenstand der Rechnung</sup></span>'
            ]
	    ],
        'nds_percent' => [
            'pattern' => '<span class="word-break">{% if nds_percent %} {{nds_percent}} {% else %} Без НДС {% endif %}</span>',
            'index' => [
                'width' => '80px',
                'display' => false
            ],
            'view' => [
                'show' => false
            ],
            'db_params' => [
                'comment' => '<span>НДС %<br><sup class="grid_list__item sup">Tax percent</sup></span>'
            ]
        ],
        'purpose' => [
            'pattern' => '<span class="word-break">{{purpose}}</span>',
            'index' => [
                'width' => '200px',
                'display' => true
            ],
            'view' => [
                'display' => true
            ],
            'db_params' => [
                'comment' => '<span>Назначение платежа</span>'
            ]
        ],
        'pay_week' => [
	        'pattern' => '{{pay_week}}',
	        'filter' => [
                'elementType' => 'selectDateWeek',
                'default_value' => null,
                'display' => true,
	            'readonly' => 'readonly',
                'label' => 'Неделя',
				'hide' => 0,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
	              'width' => '80px',
	              'display' => 0
            ],
            'view' => [
                'display' => false
            ],
            'db_params' => [
                'comment' => 'Неделя'
            ]
	    ],
	    'comment' => [
	        'pattern' => '<span class="word-break">{{comment}}</span>',
	        'index' => [
		        'width' => '200px',
		        'display' => true
            ],
            'db_params' => [
              'comment' => '<span>Примечание<br><sup class="grid_list__item sup">Anmerkungen</sup></span>'
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
            'view' => [
                'display' => false
            ],
            'index' => [
                'width' => '80px',
                'display' => false
            ],
            'db_params' => [
                'comment' => 'Флаг'
            ]
        ],
         'vo_code' => [
            'pattern' => '<span class="word-break">{{vo_code}}</span>',
            'index' => [
                'width' => '140px',
                'display' => false
            ],
            'view' => [
                'show' => true
            ],
            'db_params' => [
                'comment' => '<span>Код валютной операции<br><sup class="grid_list__item sup">Currency transaction code</sup></span>'
            ]
        ],
        'vo_type' => [
            'pattern' => '<span class="word-break">{{vo_type}}</span>',
            'index' => [
                'width' => '80px',
                'display' => false
            ],
            'view' => [
                'display' => false
            ],
            'db_params' => [
                'comment' => '<span>Тип валютной операции<br><sup class="grid_list__item sup">Type of transaction</sup></span>'
            ]
        ]
    ];

    public $links = [];

}
