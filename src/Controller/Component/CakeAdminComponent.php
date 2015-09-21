<?php
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

    protected $_Controller = null;

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->_Controller = $this->_registry->getController();
    }

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

    public function isLoggedIn()
    {
        $session = $this->_Controller->request->session();
        if ($session->check('Auth.CakeAdmin')) {
            return (bool)$session->read('Auth.CakeAdmin');
        }
        return false;
    }

    public function authUser()
    {
        $session = $this->_Controller->request->session();
        if ($session->check('Auth.CakeAdmin')) {
            return $session->read('Auth.CakeAdmin');
        }
        return false;
    }
}
