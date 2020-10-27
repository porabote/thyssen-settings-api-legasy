<?php
namespace Docs\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
 
class PatternGroupsTable extends Table 
{ 


    public function initialize(array $config)
    {
        $this->addBehavior('Tree');

        $this->belongsToMany('Patterns', [
           // 'foreignKey' => 'group_id'
        ]);

    }

    public $contain_map = [];
    public $links = [];

} 
?>
