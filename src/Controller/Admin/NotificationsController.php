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

    /**
     * beforeFilter event.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        // notifications for index-action have to be loaded here because of the loaded count of unread notifications.
        $this->set('notifications', $this->Notifier->getNotifications());
        $this->Notifier->markAsRead();

        parent::beforeFilter($event);
    }

    /**
     * Index action.
     *
     * @return void
     */
    public function index()
    {
    }
}
