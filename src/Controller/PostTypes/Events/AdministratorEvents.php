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
namespace CakeAdmin\Controller\PostTypes\Events;

use Cake\Core\Exception\Exception;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class AdministratorEvents implements EventListenerInterface {

    public function implementedEvents()
    {
        return [
            'Controller.PostTypes.Administrators.beforeEdit' => 'beforeEdit',
            'Controller.PostTypes.Administrators.beforeDelete' => 'beforeDelete'
        ];
    }

    public function beforeEdit($event, $id)
    {
        $controller = $event->subject;
        $model = TableRegistry::get('CakeAdmin.Administrators');

        if(!$model->isOwnedBy($model->get($id), $controller->Auth->user())) {
            throw new Exception('You are not allowed to change this data.');
        }
    }

    public function beforeDelete($event, $id)
    {
        $controller = $event->subject;
        $model = TableRegistry::get('CakeAdmin.Administrators');

        if(!$model->isOwnedBy($model->get($id), $controller->Auth->user())) {
            throw new Exception('You are not allowed to delete this data.');
        }
    }
}