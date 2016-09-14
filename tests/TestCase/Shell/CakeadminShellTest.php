<?php
namespace Bakkerij\CakeAdmin\Test\TestCase\Shell;

use Bakkerij\CakeAdmin\Shell\CakeadminShell;
use Cake\TestSuite\TestCase;

/**
 * Bakkerij\CakeAdmin\Shell\CakeadminShell Test Case
 */
class CakeadminShellTest extends TestCase
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
     * @var \Bakkerij\CakeAdmin\Shell\CakeadminShell
     */
    public $Cakeadmin;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->Cakeadmin = new CakeadminShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cakeadmin);

        parent::tearDown();
    }

    /**
     * Test getOptionParser method
     *
     * @return void
     */
    public function testGetOptionParser()
    {
        $this->markTestIncomplete('Not implemented yet.');
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
