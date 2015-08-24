<?php
namespace CakeAdmin\Model\Table;

use Cake\Core\Configure;
use Cake\Event\EventManager;
use CakeAdmin\Controller\PostTypes\Events\AdministratorEvents;
use CakeAdmin\Model\Entity\Administrator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Administrators Model
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
        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior('Utils.IsOwnedBy', [
            'column' => 'id'
        ]);
    }

    public function postType()
    {
        EventManager::instance()->on(new AdministratorEvents());

        return [
            'formFields' => [
                'email',
                'new_password' => [
                    'type' => 'password',
                ],
                'confirm_password' => [
                    'type' => 'password'
                ]
            ],
            'tableColumns' => [
                'id',
                'email',
                'created',
            ],
            'filters' => [
                'email'
            ],
        ];
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email');

        $validator
            ->allowEmpty('password');

        $validator
            ->allowEmpty('new_password');


        $validator
            ->allowEmpty('confirm_password');

        $validator
            ->add('new_password', 'custom', [
                'rule' => function ($value, $context) {
                    if ($value !== $context['data']['confirm_password']) {
                        return false;
                    }
                    return true;
                },
                'message' => __('Passwords are not equal.'),
            ]);

        $validator
            ->add('confirm_password', 'custom', [
                'rule' => function ($value, $context) {
                    if ($value !== $context['data']['new_password']) {
                        return false;
                    }
                    return true;
                },
                'message' => __('Passwords are not equal.'),
            ]);

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


    public function beforeFind($event, $query, $options, $primary)
    {
        $query->where(['Administrators.cakeadmin' => true]);
    }

    /**
     * beforeSave event
     *
     * @param \Cake\Event\Event $event Event.
     * @param \Cake\ORM\Entity $entity Entity.
     * @param array $options Options.
     * @return void
     */
    public function beforeSave($event, $entity, $options)
    {
        $entity->set('cakeadmin', true);

        $newPassword = $entity->get('new_password');

        if (!empty($newPassword)) {
            $entity->set('password', $entity->new_password); // set for password-changes
        }
    }

    /**
     * generateRequestKey
     *
     * This method generates a request key for an user.
     * It returns a generated string.
     *
     * @return string
     */
    public function generateRequestKey()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $requestKey = '';
        for ($i = 0; $i < 40; $i++) {
            $requestKey .= $characters[rand(0, $charactersLength - 1)];
        }
        return $requestKey;
    }

    /**
     * validateRequestKey
     *
     * Checks if an user is allowed to do an action with a required activation-key
     *
     * @param string $email E-mailaddress of the user.
     * @param string $activationKey Activation key of the user.
     * @return bool
     */
    public function validateRequestKey($email, $requestKey = null)
    {
        if (!$requestKey) {
            return false;
        }

        $field = Configure::read('CA.fields.username');
        $query = $this->find('all')->where([
            $field => $email,
            'request_key' => $requestKey
        ]);

        if ($query->Count() > 0) {
            return true;
        }
        return false;
    }

}
