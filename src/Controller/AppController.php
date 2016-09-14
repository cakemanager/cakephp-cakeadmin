<?php

namespace Bakkerij\CakeAdmin\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Crud\Controller\ControllerTrait;

class AppController extends BaseController
{

    use ControllerTrait;

    use CakeAdminTrait;

    /**
     * Initialize AppController
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->initializeCakeAdmin();

        $this->loadComponent('Flash');

        $this->loadComponent('Gourmet/KnpMenu.Menu');

        $this->loadComponent('Bakkerij/CakeAdmin.CakeAdmin');

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'authenticate' => [
                'Basic' => [
                    'userModel' => 'Bakkerij/CakeAdmin.Administrators'
                ],
                'Form' => [
                    'userModel' => 'Bakkerij/CakeAdmin.Administrators',
                    'fields' => Configure::read('CA.fields'),
                    'scope' => ['Administrators.active' => true]
                ],
            ],
            'loginAction' => [
                'prefix' => 'admin',
                'plugin' => 'Bakkerij/CakeAdmin',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'prefix' => 'admin',
                'plugin' => 'Bakkerij/CakeAdmin',
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'prefix' => 'admin',
                'plugin' => 'Bakkerij/CakeAdmin',
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);

        $this->Auth->__set('sessionKey', 'Auth.CakeAdmin');
    }

    /**
     * Authorizes every administrator on every action.
     *
     * @param array $user User to authorize.
     * @return bool
     */
    public function isAuthorized($user = null)
    {
        return true;
    }

    public function beforeFilter(Event $event)
    {
        $this->CakeAdmin->loadPostTypesFromConfig();

        $this->buildMenu();

        $this->__trigger('CakeAdmin.Controller.beforeFilter');
    }

    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->helpers([
            'Gourmet/KnpMenu.Menu'
        ]);

        $this->__trigger('CakeAdmin.Controller.beforeRender');
    }

    public function afterFilter(Event $event)
    {
        $this->__trigger('CakeAdmin.Controller.shutdown');
    }

}
