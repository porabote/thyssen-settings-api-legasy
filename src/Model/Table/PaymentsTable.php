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

    public function beforeSave($event, $entity, $options) {

        $session = new Session();
        if(!$entity->user_id) $entity->user_id = $session->read('Auth.User.id');
        //if(!$entity->user_id) $entity->manager_id = $session->read('Auth.User.id');

		# Форматируем дату публикации		
		//if(!empty($_POST['date_deadline'])) $entity->date_deadline = date("Y-m-d H:i:s", strtotime($_POST['date_deadline']));
    }


    public $check_list = [
        'summa' => [ 
            'rules' => [ 
                'notEmpty' 
            ] 
        ]               
    ];




    public $contain_map = [
	    'status_id' => [
		    'leftJoin' => 'Statuses',
	        'pattern' => '
                <div class="checkboxToggle__wrap">
                    <input type="checkbox" class="checkboxToggle payments-status" {% if status_id == 42 %} checked="checked" {% endif %} id="statusFor{{id}}" record-id="{{id}}" />
                    <label for="statusFor{{id}}"></label>
                </div>        
	        ',
	        'index' => [
		        'width' => '60px',
		        'show' => 1
            ],
            'db_params' => [
              'comment' => 'Акцепт.'
            ]
	    ],
	    'id' => [
	        'pattern' => '<a href="/purchaseRequest/view/{{id}}/">{{id}}</a>',
	        'index' => [
		        'width' => '70px',
		        'show' => 1
	        ],
            'db_params' => [
              'comment' => '<span>Номер<br><sup class="grid_list__item sup">ID</sup></span>'
            ]
	    ],
	    'contractor_id' => [
		    'leftJoin' => 'Contractors',
	        'pattern' => '{{contractor.name}}',
	        'index' => [
		        'width' => '150px',
		        'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Contractors',
	            'url' => '/contractors/getAjaxList/',
	            'uri' => [
	                'where' => ['model IN' => ['Companies', 'Entrepreneurs'], 'type' => 'client']
	            ],
				'hide' => 0,
				'default_value' => null,
				'show' => 0,
				'output_type' => 'select',
				'operator' => '='
	        ],
            'db_params' => [
              'comment' => '<span>Контрагент<br><sup class="grid_list__item sup">Firma</sup></span>'
            ]	        
	    ],
	    'bill_id' => [
		    'leftJoin' => 'Bills',
	        'pattern' => '<a href="/store/bills/view/{{bill.id}}"><b>{{bill.number}}</b></a><br> от {{bill.date}}',
	        'index' => [
		        'width' => '150px',
		        'show' => 1
            ],
	        'filter' => [
		        'modelName' => 'Contractors',
	            'url' => '/contractors/getAjaxList/',
	            'uri' => [
	                'where' => ['model IN' => ['Companies', 'Entrepreneurs'], 'type' => 'client']
	            ],
				'hide' => 0,
				'default_value' => null,
				'show' => 0,
				'output_type' => 'select',
				'operator' => '='
	        ],
            'db_params' => [
              'comment' => '<span>Счет (номер - дата)<br><sup class="grid_list__item sup">Bill (Nummer - Datum)</sup></span>'
            ]	        
	    ],
	    'bill.comment' => [
	        'pattern' => '<span class="word-break">{{bill.comment}}</span>',
	        'index' => [
		        'width' => '200px',
		        'show' => 1
            ],
            'db_params' => [
              'comment' => '<span>Предмет счёта<br><sup class="grid_list__item sup">Gegenstand der Rechnung</sup></span>'
            ]
	    ],
	    'summa' => [
            'pattern' => '{{summa|number_format(2,\'.\',\',\')}} {{currency}}',
            'index' => [
	            'width' => '120px',
	            'show' => 1
            ],
            'db_params' => [
              'comment' => '<span>Сумма<br><sup class="grid_list__item sup">Betrag</sup></span>'
            ]
	    ],
	    'rate_euro' => [
            'pattern' => '{% if currency == "RUR" and rate_euro %}{{ (summa / rate_euro)|number_format(2,\'.\',\',\') }} 
                          {% elseif currency == "EUR" %} {{summa|number_format(2,\'.\',\',\')}} 
                          {% else %} -
                          {% endif %}',
            'index' => [
	            'width' => '120px',
	            'show' => 1
            ],
            'db_params' => [
              'comment' => '<span>Сумма (ЕВРО)<br><sup class="grid_list__item sup">Betrag (EUR)</sup></span>'
            ]
	    ],
	    'comment' => [
	        'pattern' => '<span class="word-break">{{comment}}</span>',
	        'index' => [
		        'width' => '180px',
		        'show' => 1
            ],
            'db_params' => [
              'comment' => '<span>Предмет счёта<br><sup class="grid_list__item sup">Gegenstand der Rechnung</sup></span>'
            ]
	    ],
	    'date_payment' => [
	        'pattern' => '<span class="word-break">{{date_payment|date("m/d/Y")}} ({{pay_week}})</span>',
		    'index' => [
		        'width' => '140px',
		        'show' => 1
            ],
            'db_params' => [
              'comment' => '<span>День выплаты<br><sup class="grid_list__item sup">Zahltag</sup></span>'
            ] 
	    ],
        'pay_week' => [
	        'pattern' => '{{pay_week}}',
	        'filter' => [
		        'finType' => 'static',
	            'readonly' => 'readonly',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
	              'width' => '80px',
	              'show' => 0
            ],
            'db_params' => [
                'comment' => 'Неделя'
            ]
	    ],
	    'comment' => [
	        'pattern' => '<span class="word-break">{{comment}}</span>',
	        'index' => [
		        'width' => '200px',
		        'show' => 1
            ],
            'db_params' => [
              'comment' => '<span>Примечание<br><sup class="grid_list__item sup">Anmerkungen</sup></span>'
            ]
	    ],
        'object_id' => [
	    	'leftJoin' => 'Objects',
	        'pattern' => '{{object.name}}',
	        'filter' => [
	    	    'modelAlias' => 'Departments',
	            'url' => '/departments/getAjaxList/',
	            'uri' => '{
		            "where" : {"custom_type" : "5"}
	            }',
	            'readonly' => 'readonly',
				'hide' => 0,
				'default_value' => null,
				'show' => 1,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'
	        ],
	        'index' => [
	              'width' => '100px',
	              'show' => 1
            ],
            'db_params' => [
                'comment' => 'Обьект'
            ]
	    ]
    ];


	public $links = [
/*
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/payments/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ]
*/
	];



    
}
