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
use Settings\Core\Setting;
use Cake\Event\EventManager;
use CakeAdmin\Event\CakeAdminMailer;

# Plugins
Plugin::load('Utils', []);
Plugin::load('Settings', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Notifier', ['bootstrap' => true, 'routes' => true]);


# Configurations
Configure::write('Session.timeout', 4320);

Configure::write('CA.theme', 'CakeAdmin');
Configure::write('CA.viewClass', null);

Configure::write('CA.layout.default', 'CakeAdmin.default');
Configure::write('CA.layout.login', 'CakeAdmin.login');

Configure::write('CA.fields', [
    'username' => 'email',
    'password' => 'password'
]);

Configure::write('CA.email.from', ['admin@cakemanager.org' => 'Bob | CakeManager']);

Configure::write('CA.email.transport', 'default');

Configure::write('CA.Menu.main', []);

Configure::write('Settings.Prefixes.CA', 'CakeAdmin');

Configure::write('CA.PostTypes', []);

Configure::write('CA.Models.administrators', 'CakeAdmin.Administrators');


# Settings
Setting::register('App.Name', 'CakeAdmin Application');


# Theming
Plugin::load('LightStrap', ['bootstrap' => true, 'routes' => true]);


# Notifier RecipientList
Configure::write('Notifier.recipientLists.administrators', \Cake\ORM\TableRegistry::get('CakeAdmin.Administrators')->find('list')->toArray());


# Events
EventManager::instance()->on(new CakeAdminMailer());