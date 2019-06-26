<?php
namespace Fias\Model\Table;

use Cake\ORM\Table;
 
class SocrbaseTable extends Table
{ 

    public static function defaultConnectionName()
    {
        return 'api_fias';
    }

    public function initialize(array $config)
    {
        $this->setTable('api_fias.socrbase');
        
    }


} 
?>
