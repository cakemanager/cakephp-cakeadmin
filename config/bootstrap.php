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
use Cake\Core\Configure;
use Cake\Core\Plugin;

Plugin::load('Utils', []);
Plugin::load('Notifier', ['bootstrap' => true, 'routes' => true]);

Configure::write('Session.timeout', 4320);

Configure::write('CA.theme', 'CakeAdmin');

Configure::write('CA.layout.default', 'CakeAdmin.default');
Configure::write('CA.layout.login', 'CakeAdmin.login');

Configure::write('CA.fields', [
    'username' => 'email',
    'password' => 'password'
]);

Configure::write('CA.PostTypes', []);

Configure::write('CA.Models.administrators', 'CakeAdmin.Administrators');


