<?php
namespace CakeAdmin\Test\TestCase\Controller\Admin;

use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use CakeAdmin\Controller\Admin\UsersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeAdmin\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
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
    }

    /**
     * Test login request.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->get('/admin/login');

        $this->assertResponseSuccess();

        $this->assertResponseContains('<input type="email" name="email" class="form-control "  placeholder="E-mail" autofocus="autofocus" id="email" />');
        $this->assertResponseContains('<input type="password" name="password" class="form-control "  placeholder="Password" id="password" value="" />');
    }

    /**
     * Test login POST request.
     *
     * @return void
     */
    public function testLoginPost()
    {
        $administrators = TableRegistry::get('CakeAdmin.Administrators');

        $details = [
            'email' => 'test@cakeplugins.org',
            'password' => '12345'
        ];

        $administrators->save($administrators->newEntity($details));

        $this->post('/admin/login', [
            'email' => 'test@cakeplugins.org',
            'password' => '12345'
        ]);

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin/dashboard');

        $this->assertSession('3', 'Auth.CakeAdmin.id');
        $this->assertSession('test@cakeplugins.org', 'Auth.CakeAdmin.email');
        $this->assertSession('1', 'Auth.CakeAdmin.cakeadmin');
    }

    /**
     * Test login POST request fail.
     *
     * @return void
     */
    public function testLoginPostFail()
    {
        $administrators = TableRegistry::get('CakeAdmin.Administrators');

        $details = [
            'email' => 'test@cakeplugins.org',
            'password' => '12345'
        ];

        $administrators->save($administrators->newEntity($details));

        $this->post('/admin/login', [
            'email' => 'test@cakeplugins.org',
            'password' => '123456'
        ]);

        $this->assertResponseSuccess();
        $this->assertNoRedirect();

        $this->assertResponseContains('Invalid username or password, try again');

        $this->assertSession(null, 'Auth.CakeAdmin');
    }

    /**
     * Test login request when an user has been logged in. The user should be redirected.
     *
     * @return void
     */
    public function testLoginLoggedin()
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

        $this->get('/admin/login');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin/dashboard');
    }

    /**
     * Test if `/admin` request will be the same as the `/admin/login` request.
     *
     * @return void
     */
    public function testLoginAdminRequest()
    {
        $this->get('/admin');

        $this->assertResponseSuccess();

        $request = $this->_controller->request;

        $this->assertEquals('CakeAdmin', $request->params['plugin']);
        $this->assertEquals('Users', $request->params['controller']);
        $this->assertEquals('login', $request->params['action']);
        $this->assertEquals('admin', $request->params['prefix']);
    }

    /**
     * Test if the email in the query url will be used in the form.
     * For example: `/admin/login?email=bob@cakeplugins.org`.
     *
     * @return void
     */
    public function testLoginWithEmailInQuery()
    {
        $this->get('/admin/login?email=bob@cakeplugins.org');

        $this->assertResponseSuccess();

        $this->assertResponseContains('<input type="email" name="email" class="form-control "  placeholder="E-mail" autofocus="autofocus" id="email" value="bob@cakeplugins.org" />');
    }

    /**
     * Test logout request.
     *
     * @return void
     */
    public function testLogout()
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

        $this->get('/admin/logout');

        $this->assertSession([], 'Auth');
        $this->assertSession('You are now logged out.', 'Flash.flash.0.message');
    }

    /**
     * Test forgot request.
     *
     * @return void
     */
    public function testForgot()
    {
        $this->markTestIncomplete('This will be tested by LeoRuhland because of the theming');
    }

    /**
     * Test forgot POST request.
     *
     * @return void
     */
    public function testForgotPost()
    {
        $administrators = TableRegistry::get('CakeAdmin.Administrators');

        $this->assertNull($administrators->get(1)->get('request_key'));

        EventManager::instance()->on(
            'Dispatcher.beforeDispatch',
            ['priority' => 998],
            function ($event) {
                $mailer = $this->getMock('CakeAdmin\Mailer\CakeAdminMailer', ['send']);

                $mailer->expects($this->once())
                    ->method('send')
                    ->with($this->equalTo('reset_password'))
                    ->will($this->returnValue(true));

                $this->_controller = $this->getMock(
                    'CakeAdmin\Controller\Admin\UsersController',
                    ['getMailer'],
                    [$event->data['request'], $event->data['response']]
                );

                $this->_controller->expects($this->once())
                    ->method('getMailer')
                    ->with($this->equalTo('CakeAdmin.CakeAdmin'))
                    ->will($this->returnValue($mailer));

                $events = $this->_controller->eventManager();
                $events->on('View.beforeRender', function ($event, $viewFile) {
                    if (!$this->_viewName) {
                        $this->_viewName = $viewFile;
                    }
                });
                $events->on('View.beforeLayout', function ($event, $viewFile) {
                    $this->_layoutName = $viewFile;
                });

                $event->data['controller'] = $this->_controller;

                $event->stopPropagation();
            }
        );

        $this->post('/admin/users/forgot', [
            'email' => 'bob@cakeplugins.org'
        ]);

        $this->assertNotNull($administrators->get(1)->get('request_key'));
    }

    /**
     * Test forgot request when an user has been logged in. The user should be redirected.
     *
     * @return void
     */
    public function testForgotLoggedin()
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

        $this->post('/admin/users/forgot');

        $this->assertResponseSuccess();
        $this->assertRedirect('/login');
    }

    /**
     * Test reset request.
     *
     * @return void
     */
    public function testReset()
    {
        $administrators = TableRegistry::get('CakeAdmin.Administrators');

        $administrator = $administrators->get(1);
        $administrator->set('request_key', 'custom_request_key');
        $administrators->save($administrator);

        $this->get('/admin/users/reset/bob@cakeplugins.org/custom_request_key');

        $this->assertResponseSuccess();

        $this->assertResponseContains('<form method="post" role="form" action="/admin/users/reset/bob@cakeplugins.org/custom_request_key">');
        $this->assertResponseContains('<input type="password" name="new_password" class="form-control "  id="new-password" value="" />');
        $this->assertResponseContains('<input type="password" name="confirm_password" class="form-control "  id="confirm-password" value="" />');
    }

    /**
     * Test reset POST request.
     *
     * @return void
     */
    public function testResetLoggedin()
    {
        $administrators = TableRegistry::get('CakeAdmin.Administrators');

        $administrator = $administrators->get(1);
        $administrator->set('request_key', 'custom_request_key');
        $administrators->save($administrator);

        $this->session([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $this->get('/admin/users/reset/bob@cakeplugins.org/custom_request_key');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin?email=bob%40cakeplugins.org');

    }

    /**
     * Test forgot request when an user has been logged in. The user should be redirected.
     *
     * @return void
     */
    public function testResetInvalid()
    {
        $administrators = TableRegistry::get('CakeAdmin.Administrators');

        $administrator = $administrators->get(1);
        $administrator->set('request_key', 'custom_request_key');
        $administrators->save($administrator);

        $this->get('/admin/users/reset/bob@cakeplugins.org/wrong_request_key');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin?email=bob%40cakeplugins.org');

        $this->assertSession('Your account could not be reset.', 'Flash.flash.0.message');
    }

}
