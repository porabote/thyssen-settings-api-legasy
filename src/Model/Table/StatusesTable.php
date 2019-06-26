<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatusesTable extends Table 
    {

    public $actsAs = array('Tree');

    public function initialize(array $config)
    {
        $this->setTable('statuses');
        $this->addBehavior('Tree');      
    }
    public $contain_map = [];
    public $links = [];

}
