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

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Settings\Core\Setting;

/**
 * CakeAdmin\Controller\PostTypesController Test Case
 */
class SettingsControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures to load.
     *
     * @var array
     */
    public $fixtures = [
        'plugin.notifier.notifications',
        'plugin.settings.settings_configurations',
        'plugin.cake_admin.users',
        'core.articles'
    ];

    /**
     * Runs before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Runs after each test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        Setting::clear(true);

        Configure::write('CA.PostTypes', []);
        Configure::write('CA.Models', []);
    }

    /**
     * Test if the index request is authorized.
     *
     * @return void
     */
    public function testIndexNotAuthorized()
    {
        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/index');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin');
    }

    /**
     * Test if the index request uses the default key and shows the form.
     *
     * @return void
     */
    public function testIndexWithDefaultKey()
    {
        Setting::write('App.FirstKey', 'First Value');
        Setting::write('App.SecondKey', 'Second Value');

        Setting::write('CA.ThirthKey', 'Thirth Value');

        $this->session([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $this->get('/admin/settings');

        $this->assertResponseSuccess();
        $this->assertNoRedirect();

        $viewVars = $this->_controller->viewVars;

        $settingVar = $viewVars['settings']->toArray();

        $this->assertEquals(2, count($settingVar));
        $this->assertEquals('App.FirstKey', $settingVar[0]->name);
        $this->assertEquals('App.SecondKey', $settingVar[1]->name);

        $formElement = '<div class="form-group text"><label class="control-label"  for="0-value">FirstKey</label><input type="text" name="0[value]" class="form-control"  options=""  id="0-value" value="First Value" /></div>';
        $this->assertResponseContains($formElement);

        $formElement = '<div class="form-group text"><label class="control-label"  for="1-value">SecondKey</label><input type="text" name="1[value]" class="form-control"  options=""  id="1-value" value="Second Value" /></div>';
        $this->assertResponseContains($formElement);
    }

    /**
     * Test if the index request can handle custom keys and shows the form.
     *
     * @return void
     */
    public function testIndexWithCustomKey()
    {
        Setting::write('App.FirstKey', 'First Value');
        Setting::write('App.SecondKey', 'Second Value');

        Setting::write('CA.ThirthKey', 'Thirth Value');

        $this->session([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $this->get('/admin/settings/CA');

        $this->assertResponseSuccess();
        $this->assertNoRedirect();

        $viewVars = $this->_controller->viewVars;

        $settingVar = $viewVars['settings']->toArray();

        $this->assertEquals(1, count($settingVar));
        $this->assertEquals('CA.ThirthKey', $settingVar[0]->name);

        $formElement = '<div class="form-group text"><label class="control-label"  for="0-value">ThirthKey</label><input type="text" name="0[value]" class="form-control"  options=""  id="0-value" value="Thirth Value" /></div>';
        $this->assertResponseContains($formElement);
    }

    public function testIndexPostWithDefaultKey()
    {
        Setting::write('App.FirstKey', 'First Value');
        Setting::write('App.SecondKey', 'Second Value');

        Setting::write('CA.ThirthKey', 'Thirth Value');

        $this->session([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $settings = TableRegistry::get('Settings.Configurations');

        $this->assertEquals('First Value', $settings->findByName('App.FirstKey')->toArray()[0]['value']);

        $this->post('/admin/settings', [
            [
                'id' => '1',
                'value' => 'First Value Edited'
            ]
        ]);

        $this->assertResponseSuccess();

        $this->assertEquals('First Value Edited', $settings->findByName('App.FirstKey')->toArray()[0]['value']);
    }
}
