<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Writeoffs Model
 *
 * @property \Cake\ORM\Association\HasMany $Stores
 *
 * @method \App\Model\Entity\Writeoff get($primaryKey, $options = [])
 * @method \App\Model\Entity\Writeoff newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Writeoff[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Writeoff|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Writeoff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Writeoff[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Writeoff findOrCreate($search, callable $callback = null)
 */
class WriteoffsTable extends Table
{


    public static function defaultConnectionName()
    {
        return 'classis';
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('writeoffs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Stores', [
            'foreignKey' => 'writeoff_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
