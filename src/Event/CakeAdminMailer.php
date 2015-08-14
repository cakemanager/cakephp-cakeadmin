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
namespace CakeAdmin\Event;

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

class CakeAdminMailer implements EventListenerInterface
{

    /**
     * Returns a list of events this object is implementing. When the class is registered
     * in an event manager, each individual method will be associated with the respective event.
     *
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents()
    {
        return [
            'Controller.Admin.Users.afterForgotPassword' => 'forgotPassword',
        ];
    }

    public function forgotPassword($event, $user)
    {
        $mail = new Email('default');

        $from = Configure::read('CA.email.from');
        $fullBaseUrl = Configure::read('App.fullBaseUrl');

        $mail->viewVars([
            'user' => $user,
            'resetUrl' => $fullBaseUrl . '/admin/users/reset/' . $user['email'] . '/' . $user['request_key'],
            'baseUrl' => $fullBaseUrl,
            'loginUrl' => $fullBaseUrl . '/login',
            'from' => reset($from),
        ]);

        $mail->template('CakeAdmin.after_forgot', 'CakeAdmin.default');
        $mail->emailFormat('both');
        $mail->from($from);
        $mail->to($user['email']);
        $mail->subject(__('Forgot Password'));
        $mail->transport(Configure::read('CA.email.transport'));
        $mail->send();
    }

}