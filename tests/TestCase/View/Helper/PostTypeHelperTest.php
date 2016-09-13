<?php
namespace Bakkerij\CakeAdmin\Test\TestCase\View\Helper;

use Bakkerij\CakeAdmin\View\Helper\PostTypeHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * Bakkerij\CakeAdmin\View\Helper\PostTypeHelper Test Case
 */
class PostTypeHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Bakkerij\CakeAdmin\View\Helper\PostTypeHelper
     */
    public $PostType;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->PostType = new PostTypeHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PostType);

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
