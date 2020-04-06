<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Component\HistoryComponent;
use Cake\Http\Session;
use App\Model\Table\Router;

class MailsPatternsTable extends Table
{

    public function initialize(array $config)
    {
    }

    public function beforeSave($event, $entity, $options) {
    }


    public $validationRules = [
        'description' => [
            'rules' => [
                'notEmpty'
            ]
        ],
        'mail_title' => [
            'rules' => [
                'notEmpty'
            ]
        ],
        'mail_body' => [
            'rules' => [
                'notEmpty'
            ]
        ]
    ];


    public $contain_map = [
        'id' => [
            'pattern' => '<a href="/mailsPatterns/view/{{id}}/">{{id}}</a>',
            'index' => [
                'width' => '70px',
                'show' => 1
            ]
        ],
        'description' => [
            'pattern' => '<a href="/mailsPatterns/view/{{id}}/"><span>{{description}}</span></a>',
            'index' => [
                'width' => '300px',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Бизнес-процесс'
            ]
        ],
        'mail_title' => [
            'pattern' => '<span>{{mail_title}}</span>',
            'index' => [
                'width' => '1fr',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Заголовок письма'
            ]
        ]
    ];


    public $links = [
        'drop_panel' => [
            [
                'title' => 'Просмотр',
                'href' => '/mailsPatterns/view/{{record.id}}/',
                'class' => 'drop-button__hide-blok__link',
                'check' => false
            ]
        ],
    ];




}
