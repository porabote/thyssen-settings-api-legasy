<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PurchasesTable extends Table
{


    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('purchases');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');


        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
         //   'joinType' => 'INNER'
        ]);

        $this->belongsTo('Statuses', [
            'foreignKey' => 'statuse_id',
            'propertyName' => 'statuse'
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
        //    'joinType' => 'INNER'
        ]);
        $this->belongsTo('Stores');
        
        $this->hasMany('PurchaseNomenclatures');
        $this->hasMany('Residues')->setDependent(true);
        $this->hasMany('Histories')->setDependent(true);
    }

    public $check_list = [
	    'number' => [
	        'rules' => [
	            'notEmpty' => [ 'err_msg' => 'Не может быть пустым' ]
	        ]
        ]      
    ];

    public $contain_map = [
	    'id' => [
	        'pattern' => '<a href="/purchaseRequest/view/{{id}}/">{{id}}</a>',
	        'index' => [
		        'width' => '70px',
		        'show' => 1
	        ]
	    ],
	    'post_id' => [
		    'leftJoin' => 'Posts',
	        'pattern' => '<span class="post-info"><span class="post-fio">{{post.fio}}</span> <span class="post-name">{{post.name}}</span></span>',
	        'cell-value' => '{{post.id}}',
	        'filter' => [
		        'modelName' => 'Posts',
	            'url' => '/posts/getFindList/',
				'hide' => 0,
				'default_value' => null,
				'show' => 0,
				'operator' => '=',
				'output_type' => 'select',
				'operator_logical' => 'AND'	
	        ],
	        'index' => [
		        'width' => '220px',
		        'show' => 1
            ]
	    ],
	    'comment' => [
            'pattern' => '{{comment}}',
            'index' => [
	            'width' => '300px',
	            'show' => 1
            ]
	    ],	    
	    'date_created' => [
            'pattern' => '{{date_created}}',
            'index' => [
	            'width' => '200px',
	            'show' => 1
            ]
	    ],
	    'summa' => [
            'index' => [
	            'show' => 0
            ]
	    ],
        'order_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'contragent_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'date' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'statuse_id' => [
            'index' => [
	            'show' => 0
            ]
	    ],
	    'store_id' => [
            'index' => [
	            'show' => 0
            ]
	    ]
    ];


	public $links = [
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/purchaseRequest/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	    'checkbox_panel' => [
		    'selects' => [ 
		        [			    
                    'id' => 'checkboxPanelSelectPurchase',
                    'name' => 'checkboxList',
                    'data-params' => '{"readonly":true}',
                    'label' => 'Действие с выделенным',
                    'readonly' => 'readonly',
                    'data-params' => '{ "afterSelect" : "App|handleChecked"}',
                    'options' => [
	                    '/purchases/setFlag/delete/' => 'Отменить выделенное'
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
