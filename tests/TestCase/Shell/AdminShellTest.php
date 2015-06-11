<?php
namespace CakeAdmin\Test\TestCase\Shell;

use CakeAdmin\Shell\AdminShell;
use Cake\TestSuite\TestCase;

/**
 * CakeAdmin\Shell\AdminShell Test Case
 */
class AdminShellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');
        $this->Admin = new AdminShell($this->io);
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
