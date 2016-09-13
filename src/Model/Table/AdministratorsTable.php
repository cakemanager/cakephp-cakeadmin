<?php
namespace Bakkerij\CakeAdmin\Model\Table;

use Bakkerij\CakeAdmin\Model\Entity\Administrator;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Administrators Model
 *
 * @method Administrator get($primaryKey, $options = [])
 * @method Administrator newEntity($data = null, array $options = [])
 * @method Administrator[] newEntities(array $data, array $options = [])
 * @method Administrator|bool save(EntityInterface $entity, $options = [])
 * @method Administrator patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Administrator[] patchEntities($entities, array $data, array $options = [])
 * @method Administrator findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdministratorsTable extends Table
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

        $this->table('cakeadmin_administrators');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->allowEmpty('password');

        $validator
            ->integer('cakeadmin')
            ->allowEmpty('cakeadmin');

        $validator
            ->allowEmpty('request_key');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
