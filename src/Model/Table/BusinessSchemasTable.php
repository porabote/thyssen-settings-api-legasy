<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Component\HistoryComponent;
use Cake\Http\Session;
use App\Model\Table\Router;

class BusinessSchemasTable extends Table
{

    public function initialize(array $config)
    {
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
            'pattern' => '<a href="/BusinessSchemas/view/{{id}}/">{{id}}</a>',
            'index' => [
                'width' => '70px',
                'show' => 1
            ]
        ],
        'title' => [
            'pattern' => '<a href="/BusinessSchemas/view/{{id}}/"><span>{{title}}</span></a>',
            'index' => [
                'width' => '1fr',
                'show' => 1
            ],
            'db_params' => [
                'comment' => 'Бизнес-процесс'
            ]
        ]
    ];


    public $links = [
        'drop_panel' => [
            [
                'title' => 'Просмотр',
                'href' => '/BusinessSchemas/view/{{record.id}}/',
                'class' => 'drop-button__hide-blok__link',
                'check' => false
            ]
        ],
    ];




}
