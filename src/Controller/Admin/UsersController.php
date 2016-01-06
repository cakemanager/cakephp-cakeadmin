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
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Mailer\MailerAwareTrait;

/**
 * Users Controller
 *
 */
class UsersController extends AppController
{

    use MailerAwareTrait;

    /**
     * Initializes UsersController.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow([
            'forgot',
            'reset',
            'login'
        ]);

        $this->loadModel('CakeAdmin.Administrators');
    }

    /**
     * Login action
     *
     * Login action for administrators. Here you are able to login into your admin-panel.
     *
     * @return \Cake\Network\Response|void
     */
    public function login()
    {
        if ($this->authUser) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $user['CakeAdmin'] = $user;
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        } else {
            $this->request->data['email'] = $this->request->query('email');
        }
    }

    /**
     * Logout action
     *
     * Via this action you will be logged out and redirected to the login-page.
     *
     * @return \Cake\Network\Response|void
     */
    public function logout()
    {
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Forgot password action
     *
     * Via this action you are able to request a new password.
     * After the post it will send a mail with a link.
     * This link will redirect to the action 'reset'.
     *
     * This action always gives a success-message.
     * That's because else hackers (or other bad-guys) will be able
     * to see if an e-mail is registered or not.
     *
     * @return void|\Cake\Network\Response
     */
    public function forgot()
    {
        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        $this->Flash->success(__('Check your e-mail to change your password.'));

        if ($this->request->is('post')) {
            $user = $this->Administrators->findByEmail($this->request->data('email'));
            if ($user->count()) {
                $user = $user->first();
                $user->set('request_key', $this->Administrators->generateRequestKey());
                if ($this->Users->save($user)) {
                    $event = new Event('Controller.Admin.Users.afterForgotPassword', $this, [
                        'user' => $user
                    ]);
                    EventManager::instance()->dispatch($event);

                    $this->getMailer('CakeAdmin.CakeAdmin')->send('resetPassword', [$user]);

                    return $this->redirect($this->Auth->config('loginAction') + ['email' => $user->email]);
                }
            }

            return $this->redirect($this->Auth->config('loginAction'));
        }
    }

    /**
     * Reset password action
     *
     * Users will reach this action when they need to set a new password for their account.
     * This action will set a new password and redirect to the login page
     *
     * @param string $email The e-mailaddress from the user.
     * @param string $requestKey The refering activation key.
     * @return void|\Cake\Network\Response
     */
    public function reset($email, $requestKey = null)
    {
        // Redirect if user is already logged in
        if ($this->authUser) {
            $this->Flash->error(__('Your account could not be reset.'));
            return $this->redirect($this->Auth->config('loginAction') + ['email' => $email]);
        }

        // If the email and key doesn't match
        if (!$this->Administrators->validateRequestKey($email, $requestKey)) {
            $this->Flash->error(__('Your account could not be reset.'));
            return $this->redirect($this->Auth->config('loginAction') + ['email' => $email]);
        }

        // If we passed and the POST isset
        if ($this->request->is('post')) {
            $user = $this->Administrators->find()->where([
                'email' => $email,
                'request_key' => $requestKey,
            ])->first();

            if ($user) {
                $user = $this->Administrators->patchEntity($user, $this->request->data);
                $user->set('active', 1);
                $user->set('request_key', null);

                if ($this->Administrators->save($user)) {
                    $this->Flash->success(__('Your password has been changed.'));
                    return $this->redirect($this->Auth->config('loginAction') + ['email' => $email]);
                }
            }
            $this->Flash->error(__('Your account could not be activated.'));
        }
    }
}
