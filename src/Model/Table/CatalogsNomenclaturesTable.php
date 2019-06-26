<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CatalogsNomenclaturesTable extends Table 
    {

    public $actsAs = array('Tree');


    public function initialize(array $config)
    {
      //  $this->hasOne('Nomenclatures');
      //  $this->belongsToMany('Nomenclatures');
        
        
        $this->addBehavior('Tree');      
    }

    public $contain_map = [];
    public $links = [];

}
