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
namespace CakeAdmin\Controller\Admin;

use CakeAdmin\Controller\AppController;

/**
 * Notifications Controller
 *
 * @property \CakeAdmin\Model\Table\NotificationsTable $Notifications
 */
class NotificationsController extends AppController
{

    public function index()
    {

//        $this->Notifier->notify([
//            'users' => 1,
//            'vars' => [
//                'title' => 'New user',
//                'body' => 'A new user has been registered'
//            ]
//        ]);

        $this->set('notifications', $this->Notifier->allNotificationList());

        $this->Notifier->markAsRead();
    }
}
