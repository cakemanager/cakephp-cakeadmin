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
namespace CakeAdmin\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Notifier\Utility\NotificationManager;

/**
 * CakeAdmin component
 */
class CakeAdminComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    protected $Controller = null;

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->Controller = $this->_registry->getController();

        $this->_setRecipientList();
    }

    /**
     * setController
     *
     * Setter for the Controller property.
     *
     * @param \Cake\Controller\Controller $controller Controller.
     * @return void
     */
    public function setController($controller)
    {
        $this->Controller = $controller;
    }

    /**
     * Returns a list of administrators.
     *
     * @param null $field Non-required field, if empty all data will be returned.
     * @return array|string
     */
    public function administrators($field = null)
    {
        $model = TableRegistry::get('CakeAdmin.Administrators');

        $query = $model->find('all');

        if ($field) {
            $model->displayField($field);
            $query->find('list');
        }

        $result = $query->toArray();

        return $result;
    }

    /**
     * Checks if an administrator is logged in.
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        $session = $this->Controller->request->session();
        if ($session->check('Auth.CakeAdmin')) {
            return (bool)$session->read('Auth.CakeAdmin');
        }
        return false;
    }

    /**
     * Returns the logged in administrator.
     * Will return `false` when there'se no session.
     *
     * @return bool
     */
    public function authUser()
    {
        $session = $this->Controller->request->session();
        if ($session->check('Auth.CakeAdmin')) {
            return $session->read('Auth.CakeAdmin');
        }
        return false;
    }

    /**
     * Sets the recipient-list in the NotificationManager to notify all administrators very easily.
     * Administrators will be available under the list called `administrators`.
     *
     * @return void
     */
    protected function _setRecipientList()
    {
        NotificationManager::instance()->addRecipientList(
            'administrators',
            TableRegistry::get('CakeAdmin.Administrators')->find('list')->toArray()
        );
    }

}
