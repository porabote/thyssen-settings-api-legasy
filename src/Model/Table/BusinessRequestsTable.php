<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Component\HistoryComponent;
use Cake\Http\Session;
use App\Model\Table\Router;

class BusinessRequestsTable extends Table
{

    public function initialize(array $config)
    {
        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'propertyName' => 'status',
            'className' => 'Statuses',
        ]);

        $this->belongsTo('Acceptors', [
            'foreignKey' => 'acceptor_id',
            'propertyName' => 'acceptor',
            'className' => 'Posts',
        ]);

        $this->belongsTo('Store.Bills', [
            'foreignKey' => 'record_id',
            'conditions' => ['BusinessRequests.className' => 'Store.Bills']

        ]);

        $this->belongsTo('Contractors');
    }

    public function beforeSave($event, $entity, $options) {
    }


    public $validationRules = [
        'title' => [
            'rules' => [
                'notEmpty'
            ]
        ]
    ];


    public $contain_map = [
        'id' => [
            'pattern' => '<a href="/businessRequests/view/{{id}}/">{{id}}</a>',
            'index' => [
                'width' => '70px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'ID'
            ]
        ],
        'status_id' => [
            'leftJoin' => 'Statuses',
            'pattern' => '{{status.name}}',
            'index' => [
                'width' => '260px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Статус'
            ]
        ],
        'bill_id' => [
            'leftJoin' => 'Bills',
            'pattern' => '<u><a href="/store/bills/view/{{bill.id}}/">{{bill.number}} от {{bill.date}}</a></u>',
            'index' => [
                'width' => '165px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Счёт'
            ]
        ],
        'contractor_id' => [
            'leftJoin' => 'Contractors',
            'pattern' => '{{contractor.name}}',
            'index' => [
                'width' => '165px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Контрагент'
            ]
        ],
        'delta' => [
            'pattern' => '{{delta}}',
            'index' => [
                'width' => '140px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Дельта (РУБ)'
            ]
        ],
        'acceptor_id' => [
            'leftJoin' => 'Acceptors',
            'pattern' => '<span class="post-info"><span class="post-fio">{{acceptor.fio}}</span> <span class="post-name">{{acceptor.name}}</span></span>',
            'index' => [
                'width' => '165px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'На подписи у'
            ]
        ],
    ];


    public $links = [
        'drop_panel' => [
            [
                'title' => 'Просмотр',
                'href' => '/BusinessRequests/view/{{record.id}}/',
                'class' => 'drop-button__hide-blok__link',
                'check' => false
            ]
        ],
    ];




}
