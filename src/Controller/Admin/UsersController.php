<?php
namespace Bakkerij\CakeAdmin\Controller\Admin;

use Bakkerij\CakeAdmin\Controller\AppController;

/**
 * Users Controller
 *
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['logout']);

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'login' => 'Bakkerij/CakeAdmin.Login',
                'logout' => 'Bakkerij/CakeAdmin.Logout'
            ]
        ]);

    }

}
