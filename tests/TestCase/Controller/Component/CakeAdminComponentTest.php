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
namespace CakeAdmin\Test\TestCase\Controller\Component;

use Cake\ORM\TableRegistry;
use CakeAdmin\Controller\Component\CakeAdminComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * CakeAdmin\Controller\Component\CakeAdminComponent Test Case
 */
class CakeAdminComponentTest extends TestCase
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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();

        // Setup our component and fake test controller
        $collection = new ComponentRegistry();
        $this->CakeAdmin = $this->getMock(
            'CakeAdmin\Controller\Component\CakeAdminComponent',
            ['_setRecipientList'],
            [$collection]
        );
        $this->Controller = $this->getMock('Cake\Controller\Controller', ['redirect']);
        $this->CakeAdmin->setController($this->Controller);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CakeAdmin);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $collection = new ComponentRegistry();
        $CakeAdmin = $this->getMock(
            'CakeAdmin\Controller\Component\CakeAdminComponent',
            ['_setRecipientList'],
            [$collection]
        );

        $CakeAdmin->expects($this->once())
            ->method('_setRecipientList')
            ->will($this->returnValue(true));

        $CakeAdmin->initialize([]);
    }

    /**
     * Test setController method.
     *
     * @return void
     */
    public function testSetController()
    {
        $this->CakeAdmin->setController('No Controller');

        $this->assertEquals('No Controller', $this->CakeAdmin->Controller);
    }

    /**
     * Test if administrators-method will return list of all administrators.
     *
     * @return void
     */
    public function testAdministrators()
    {
        $result = $this->CakeAdmin->administrators();

        $this->assertArrayHasKey(0, $result);
        $this->assertInstanceOf('CakeAdmin\Model\Entity\Administrator', $result[0]);
    }

    /**
     * Test if a list of the chosen field of all administrators will be returned.
     *
     * @return void
     */
    public function testAdministratorsWithField()
    {
        $administrators = TableRegistry::get('CakeAdmin.Administrators');

        $details = [
            'email' => 'test@cakeplugins.org',
            'password' => '12345'
        ];

        $administrators->save($administrators->newEntity($details));

        $result = $this->CakeAdmin->administrators('email');

        $expected = [
            1 => 'bob@cakeplugins.org',
            3 => 'test@cakeplugins.org'
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Test if the method will return if an administrators is logged in.
     *
     * @return void
     */
    public function testIsLoggedIn()
    {
        $this->CakeAdmin->Controller->request->session()->write([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $this->assertTrue($this->CakeAdmin->isLoggedIn());
    }

    /**
     * Test that isLoggedIn-method will return `false` when no administrator is logged in.
     *
     * @return void
     */
    public function testIsLoggedInFalse()
    {
        $this->assertFalse($this->CakeAdmin->isLoggedIn());
    }

    /**
     * Test if authUser-method will return the current logged in user.
     *
     * @return void
     */
    public function testAuthUser()
    {
        $this->CakeAdmin->Controller->request->session()->write([
            'Auth' => [
                'CakeAdmin' => [
                    'id' => 1,
                    'email' => 'bob@cakeplugins.org',
                    'cakeadmin' => 1
                ]
            ]
        ]);

        $expected = [
            'id' => (int)1,
            'email' => 'bob@cakeplugins.org',
            'cakeadmin' => (int)1
        ];

        $this->assertEquals($expected, $this->CakeAdmin->authUser());
    }

    /**
     * Test that `false` will be returned when the administrator is not logged in.
     *
     * @return void
     */
    public function testAuthUserFalse()
    {
        $this->assertFalse($this->CakeAdmin->authUser());
    }
}
