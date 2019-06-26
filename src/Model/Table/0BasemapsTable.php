<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BasemapsTable extends Table 
    {
      
    public function initialize(array $config)
    {
	    //$this->setPrimaryKey('alias');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'modified' => 'always'
                ]
            ]
        ]);


    }


    public $contain_map = [];
    public $links = [];


}
