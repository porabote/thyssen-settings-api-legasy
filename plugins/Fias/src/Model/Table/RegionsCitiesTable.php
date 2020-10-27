<?php
namespace Fias\Model\Table;

use Cake\ORM\Table;
 
class RegionsCitiesTable extends Table
{ 

    public static function defaultConnectionName()
    {
        return 'api_fias';
    }

    public function initialize(array $config)
    {
        $this->setTable('api_fias.regions_cities');
        
    }

    public $contain_map = [];
    public $links = [];

} 
?>
