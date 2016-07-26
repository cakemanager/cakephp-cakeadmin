<?php
namespace Bakkerij\CakeAdmin\Test\TestCase\Shell\Task;

use Bakkerij\CakeAdmin\Shell\Task\AdminTask;
use Cake\TestSuite\TestCase;

/**
 * Bakkerij\CakeAdmin\Shell\Task\AdminTask Test Case
 */
class AdminTaskTest extends TestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \Bakkerij\CakeAdmin\Shell\Task\AdminTask
     */
    public $Admin;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();

        $this->Admin = $this->getMockBuilder('Bakkerij\CakeAdmin\Shell\Task\AdminTask')
            ->setConstructorArgs([$this->io])
            ->getMock();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Admin);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
