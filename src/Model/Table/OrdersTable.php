<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table 
    {

    public function initialize(array $config)
    {

        $this->belongsTo('Companies');
        $this->belongsTo('Users');
        $this->belongsTo('Statuses', ['foreignKey' => 'statuse_id']);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated_at' => 'always',
                ],
                'Orders.completed' => [
                    'completed_at' => 'always'
                ]
            ]
        ]);


    }


    public $contain_map = [];
    public $links = [];
}
