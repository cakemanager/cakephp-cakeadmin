<?php
namespace CakeAdmin\Controller;

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
