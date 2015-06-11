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
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeAdmin\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Flash');

        $this->loadComponent('CakeAdmin.CakeAdmin');

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'authenticate' => [
                'Basic' => [
                    'userModel' => 'CakeAdmin.Administrators'
                ],
                'Form' => [
                    'userModel' => 'CakeAdmin.Administrators',
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ],
                    'scope' => ['Administrators.cakeadmin' => true]
                ],
            ],
            'loginAction' => [
                'plugin' => 'CakeAdmin',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'plugin' => 'CakeAdmin',
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'plugin' => 'CakeAdmin',
                'controller' => 'Users',
                'action' => 'login'
            ],
        ]);

        $this->Auth->sessionKey = 'Auth.CakeAdmin';
        $this->authUser = $this->Auth->user();

        $this->loadComponent('Utils.Menu');

        $this->loadComponent('CakeAdmin.PostTypes');

        $this->loadComponent('Notifier.Notifier');
    }

    public function beforeFilter(Event $event)
    {
        if ($this->authUser) {
            $this->layout = 'CakeAdmin.default';
        } else {
            $this->layout = 'CakeAdmin.login';
        }
    }

    public function beforeRender(Event $event)
    {
        $this->set('authUser', $this->authUser);
        $this->set('title', $this->name);
    }

    public function isAuthorized($user = null)
    {
        return true;
    }

    public function initMenuItems()
    {
        $this->Menu->area('headerLeft');

        $this->Menu->add('ca.dashboard', [
            'title' => $this->authUser['email'],
            'url' => [
                'prefix' => false,
                'plugin' => 'CakeAdmin',
                'controller' => 'Dashboard',
                'action' => 'index',
            ]
        ]);

        $this->Menu->add('notifier.notifications', [
            'title' => 'Notifications (' . $this->Notifier->notificationCount() . ')',
            'url' => [
                'prefix' => false,
                'plugin' => 'CakeAdmin',
                'controller' => 'Notifications',
                'action' => 'index',
            ]
        ]);

        $this->Menu->add('ca.logout', [
            'title' => __('Logout'),
            'url' => [
                'prefix' => false,
                'plugin' => 'CakeAdmin',
                'controller' => 'Users',
                'action' => 'logout',
            ]
        ]);

        $this->Menu->area('main');

        $this->Menu->add('ca.dashboard', [
            'title' => __('Dashboard'),
            'url' => [
                'prefix' => false,
                'plugin' => 'CakeAdmin',
                'controller' => 'Dashboard',
                'action' => 'index',
            ]
        ]);
    }

}
