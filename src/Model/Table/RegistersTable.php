<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Groups
 * @property \Cake\ORM\Association\HasMany $Comments
 * @property \Cake\ORM\Association\HasMany $Companies
 * @property \Cake\ORM\Association\HasMany $Contacts
 * @property \Cake\ORM\Association\HasMany $Peoples
 * @property \Cake\ORM\Association\HasMany $Plannings
 */
class RegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('registers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);



        $this->hasOne('Contracts', [
            'foreignKey' => 'reg_id'
        ]);

        $this->belongsTo('Distributor', [
            'foreignKey' => 'dstr_id',
            'joinType' => 'INNER',
            'className' => 'Companies',
            'joinTable' => 'companies'
        ]);


        $this->belongsTo('Beneficiary', [
            'foreignKey' => 'bfcr_id',
            'joinType' => 'INNER',
            'className' => 'Companies',
            'joinTable' => 'companies'
        ]);

        $this->belongsTo('Users'); 
       
/*
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id'
        ]);
*/
    }

    public $contain_map = [];
    public $links = [];


}
