<?php
namespace CakeAdmin\Controller;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use CakeAdmin\Controller\AppController;

/**
 * Dashboard Controller
 *
 * @property \CakeAdmin\Model\Table\DashboardTable $Dashboard
 */
class DashboardController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->Menu->active('ca.dashboard');
        
//        debug($this->authUser);

//        debug(Configure::read('CA'));

//        debug($this->PostTypes->getPostTypesList());

    }

}
