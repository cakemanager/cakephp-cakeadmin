<?php
namespace Bakkerij\CakeAdmin\Test\TestCase\Controller\Component;

use Bakkerij\CakeAdmin\Controller\Component\CakeAdminComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * Bakkerij\CakeAdmin\Controller\Component\CakeAdminComponent Test Case
 */
class CakeAdminComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Bakkerij\CakeAdmin\Controller\Component\CakeAdminComponent
     */
    public $CakeAdmin;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->CakeAdmin = new CakeAdminComponent($registry);
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
        $this->markTestIncomplete('Not implemented yet.');
    }
}
