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
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeAdmin\Controller\DashboardController Test Case
 */
class DashboardControllerTest extends IntegrationTestCase
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
        $this->get('/admin/dashboard');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin');
    }

    public function testIndex()
    {
        $this->session([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $this->get('/admin/dashboard');

        $this->assertResponseSuccess();
        $this->assertNoRedirect();

        $this->assertLayout('default');
        $this->assertLayout('lightstrap');
        $this->assertTemplate('index');
        $this->assertTemplate('lightstrap');

        $this->assertResponseContains('<li class="active"><a href="/admin/dashboard">Dashboard</a></li>');
    }
}
