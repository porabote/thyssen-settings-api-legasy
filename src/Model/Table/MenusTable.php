<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
 
class MenusTable extends Table 
{ 
    public static function defaultConnectionName()
    {
        return 'api';
    }

    public function initialize(array $config)
    {
        $this->addBehavior('Tree');
        $this->setTable('api_default.menus');

    }

    public $contain_map = [
		//'contractor_id' => [ 'model' => 'Contractors', 'alias' => 'contractor', 'fields' => 'name', 'assoc_type' =>  'belongsTo' ]
    ];


    public $check_list = [               
    ];

	public $links = [
	]; 

} 
?>
