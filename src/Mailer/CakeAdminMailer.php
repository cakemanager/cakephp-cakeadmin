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
namespace CakeAdmin\Mailer;

use Cake\Mailer\Mailer;
use Cake\Core\Configure;
use Settings\Core\Setting;

class CakeAdminMailer extends Mailer
{

    /**
     * reset_password
     *
     * Sends mail if an user requested a new password.
     *
     * @param $user User entity.
     * @return void
     */
    public function reset_password($user)
    {
        $from = Configure::read('CA.email.from');
        $fullBaseUrl = Setting::read('App.BaseUrl');

        $this->domain($fullBaseUrl);

        $this->viewVars([
            'user' => $user,
            'resetUrl' => $fullBaseUrl . '/admin/users/reset/' . $user['email'] . '/' . $user['request_key'],
            'baseUrl' => $fullBaseUrl,
            'loginUrl' => $fullBaseUrl . '/admin',
            'from' => reset($from),
        ]);

        $this->template('CakeAdmin.reset_password', 'CakeAdmin.default');
        $this->emailFormat('both');
        $this->from($from);
        $this->to($user['email']);
        $this->subject(__('Forgot Password'));
        $this->transport(Configure::read('CA.email.transport'));
    }

}
