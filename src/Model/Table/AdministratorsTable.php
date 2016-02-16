<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeAdmin\Model\Table;

use CakeAdmin\Model\Entity\Administrator;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Notifier\Utility\NotificationManager;

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

    /**
     * Configures the PostType for CakeAdmin.
     *
     * @return array
     */
    public function postType()
    {
        return [
            'alias' => __d('CakeAdmin', 'Administrators'),
            'aliasLc' => __d('CakeAdmin', 'administrators'),
            'singularAlias' => __d('CakeAdmin', 'Administrator'),
            'singularAliasLc' => __d('CakeAdmin', 'administrator'),
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
            ->notEmpty('email');

        $validator
            ->notEmpty('password');

        $validator
            ->allowEmpty('new_password');


        $validator
            ->allowEmpty('confirm_password');

        $validator
            ->add('new_password', 'custom', [
                'rule' => function ($value, $context) {
                    if (!array_key_exists('confirm_password', $context['data'])) {
                        return false;
                    }
                    if ($value !== $context['data']['confirm_password']) {
                        return false;
                    }
                    return true;
                },
                'message' => __d('CakeAdmin', 'Passwords are not equal.')]);

        $validator
            ->add('confirm_password', 'custom', ['rule' => function ($value, $context) {
                if (!array_key_exists('new_password', $context['data'])) {
                    return false;
                }
                if ($value !== $context['data']['new_password']) {
                    return false;
                }
                return true;
            },
                'message' => __d('CakeAdmin', 'Passwords are not equal.')]);

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

    /**
     * beforeFind event.
     *
     * @param \Cake\Event\Event $event Event.
     * @param \Cake\ORM\Query $query Query.
     * @param array $options Options.
     * @param bool $primary Primary.
     * @return void
     */
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
     * afterSave event
     *
     * @param \Cake\Event\Event $event Event.
     * @param \Cake\ORM\Entity $entity Entity.
     * @param array $options Options.
     * @return void
     */
    public function afterSave($event, $entity, $options)
    {
        if ($entity->isNew()) {
            NotificationManager::instance()->notify([
                'recipientLists' => ['administrators'],
                'template' => 'newAdministrator',
                'vars' => [
                    'email' => $entity->get('email'),
                    'created' => $entity->get('created'),
                ]
            ]);
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
     * @param string $requestKey Activation key of the user.
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
