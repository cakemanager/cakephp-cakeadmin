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
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeAdmin\Test\TestCase\Controller\Admin;

use Cake\Core\Plugin;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Notifier\Utility\NotificationManager;

/**
 * CakeAdmin\Controller\NotificationsController Test Case
 */
class NotificationsControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.notifier.notifications',
        'plugin.settings.settings_configurations',
        'plugin.cake_admin.users',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexNotAuthorized()
    {
        $this->get('/admin/notifications');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin');
    }

    public function testIndex()
    {
        NotificationManager::instance()->notify([
            'users' => [1],
            'vars' => [
                'title' => 'Testing the title',
                'body' => 'Testing the body'
            ]
        ]);

        $this->session([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $this->get('/admin/notifications');

        $this->assertResponseSuccess();
        $this->assertNoRedirect();

        $viewVars = $this->_controller->viewVars;

        $this->assertArrayHasKey('notifications', $viewVars);
        $this->assertArrayHasKey(0, $viewVars['notifications']);
        $this->assertInstanceOf('Notifier\Model\Entity\Notification', $viewVars['notifications'][0]);

        $this->assertResponseContains('Testing the title');
        $this->assertResponseContains('Testing the body');
    }
}
