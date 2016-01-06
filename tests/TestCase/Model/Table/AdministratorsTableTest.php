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
namespace CakeAdmin\Test\TestCase\Model\Table;

use CakeAdmin\Model\Table\AdministratorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class AdministratorsTableTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cake_admin.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        $this->Administrators = TableRegistry::get('CakeAdmin.Administrators');

        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Administrators);

        parent::tearDown();
    }

    /**
     * Test find query method; only users with `cakeadmin` column on `true` will be queried.
     *
     * @return void
     */
    public function testFindQuery()
    {
        $result = $this->Administrators->find();

        $this->assertEquals(1, $result->count());
    }

    /**
     * Before an administrator will be saved, `cakeadmin` must be true.
     *
     * @return void
     */
    public function testBeforeSave()
    {
        $data = [
            'email' => 'test@cakeplugins.org',
            'password' => 12345
        ];

        $this->Administrators->save($this->Administrators->newEntity($data));

        $result = $this->Administrators->get(3);

        $this->assertEquals(1, $result->get('cakeadmin'));
    }

    /**
     * Test if new password will be set.
     *
     * @return void
     */
    public function testNewPassword()
    {
        $entity = $this->Administrators->get(1);

        $oldPassword = $entity->get('password');

        $data = [
            'new_password' => '54321',
            'confirm_password' => '54321',
        ];

        $this->Administrators->save($this->Administrators->patchEntity($entity, $data));

        $this->assertEquals(0, count($entity->errors()));

        $result = $this->Administrators->get(1);

        $this->assertNotEquals($oldPassword, $result->get('password'));
    }

    /**
     * Test that new password won't be set without confirm_password.
     *
     * @return void
     */
    public function testNewPasswordWithoutConfirmation()
    {
        $entity = $this->Administrators->get(1);

        $oldPassword = $entity->get('password');

        $data = [
            'new_password' => '54321'
        ];

        $this->Administrators->save($this->Administrators->patchEntity($entity, $data));

        $this->assertEquals(1, count($entity->errors()));

        $result = $this->Administrators->get(1);

        $this->assertEquals($oldPassword, $result->get('password'));
    }
}
