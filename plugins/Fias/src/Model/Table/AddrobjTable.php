<?php
namespace Fias\Model\Table;

use Cake\ORM\Table;
 
class AddrobjTable extends Table
{ 

    public static function defaultConnectionName()
    {
        return 'api_fias';
    }

    public function initialize(array $config)
    {
	    //$this->setPrimaryKey('AOID');
        $this->setTable('api_fias.addrobj');
        
    }


} 
?>
