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
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeAdmin\Controller\PostTypesController Test Case
 */
class PostTypesControllerTest extends IntegrationTestCase
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
     * Test if exception is called if the posttype does not exist.
     *
     * @expectedException
     * @return void
     */
    public function testIndexNoPostType()
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

        $this->get('/admin/posttypes/articles/index');

        $this->assertResponseFailure();
    }

    /**
     * Test index request on registered posttype.
     *
     * @return void
     */
    public function testIndexWithPostType()
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

        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/index');

        $this->assertResponseSuccess();

        $this->assertResponseContains('<li class="active"><a href="/admin/posttypes/articles/index">Articles</a></li>');

        $this->assertLayout('default.ctp');
        $this->assertTemplate(DS . 'Template' . DS . 'Admin' . DS . 'PostTypes' . DS . 'index.ctp');
    }

    /**
     * Test if the view request is authorized.
     *
     * @return void
     */
    public function testViewNotAuthorized()
    {
        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/view/1');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin');
    }

    /**
     * Test if exception is called if the posttype does not exist.
     *
     * @return void
     */
    public function testViewNoPostType()
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

        $this->get('/admin/posttypes/articles/view/1');

        $this->assertResponseFailure();
    }

    /**
     * Test view request on registered posttype.
     *
     * @return void
     */
    public function testViewWithPostType()
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

        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/view/1');

        $this->assertResponseSuccess();

        $this->assertResponseContains('<li class="active"><a href="/admin/posttypes/articles/index">Articles</a></li>');

        $this->assertLayout('default.ctp');
        $this->assertTemplate(DS . 'Template' . DS . 'Admin' . DS . 'PostTypes' . DS . 'view.ctp');
    }

    /**
     * Test if the add request is authorized.
     *
     * @return void
     */
    public function testAddNotAuthorized()
    {
        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/add');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin');
    }

    /**
     * Test if exception is called if the posttype does not exist.
     *
     * @return void
     */
    public function testAddNoPostType()
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

        $this->get('/admin/posttypes/articles/add');

        $this->assertResponseFailure();
    }

    /**
     * Test add request on registered posttype.
     *
     * @return void
     */
    public function testAddWithPostType()
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

        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/add');

        $this->assertResponseSuccess();

        $this->assertResponseContains('<li class="active"><a href="/admin/posttypes/articles/index">Articles</a></li>');

        $this->assertLayout('default.ctp');
        $this->assertTemplate(DS . 'Template' . DS . 'Admin' . DS . 'PostTypes' . DS . 'add.ctp');
    }

    /**
     * Test add POST request on registered posttype.
     *
     * @return void
     */
    public function testAddPostWithPostType()
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

        Configure::write('CA.Models.articles', 'Articles');

        $articles = TableRegistry::get('Articles');

        $this->post('/admin/posttypes/articles/add', [
            'author_id' => 1,
            'title' => 'Fourth article',
            'body' => 'Fourth Article Body',
            'published' => 'Y'
        ]);

        $this->assertResponseSuccess();

        $this->assertEquals(4, $articles->find()->count());
    }

    /**
     * Test if the edit request is authorized.
     *
     * @return void
     */
    public function testEditNotAuthorized()
    {
        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/edit/1');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin');
    }

    /**
     * Test if exception is called if the posttype does not exist.
     *
     * @return void
     */
    public function testEditNoPostType()
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

        $this->get('/admin/posttypes/articles/edit/1');

        $this->assertResponseFailure();
    }

    /**
     * Test edit request on registered posttype.
     *
     * @return void
     */
    public function testEditWithPostType()
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

        Configure::write('CA.Models.articles', 'Articles');

        $this->get('/admin/posttypes/articles/edit/1');

        $this->assertResponseSuccess();

        $this->assertResponseContains('<li class="active"><a href="/admin/posttypes/articles/index">Articles</a></li>');

        $this->assertLayout('default.ctp');
        $this->assertTemplate(DS . 'Template' . DS . 'Admin' . DS . 'PostTypes' . DS . 'edit.ctp');
    }

    /**
     * Test edit POST request on registered posttype.
     *
     * @return void
     */
    public function testEditPostWithPostType()
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

        Configure::write('CA.Models.articles', 'Articles');

        $articles = TableRegistry::get('Articles');

        $article = $articles->get(1);

        $this->assertEquals('First Article', $article->title);

        $this->post('/admin/posttypes/articles/edit/1', [
            'title' => 'First Article Edited',
        ]);

        $this->assertResponseSuccess();

        $article = $articles->get(1);

        $this->assertEquals('First Article Edited', $article->title);
    }

    /**
     * Test if the delete request is authorized.
     *
     * @return void
     */
    public function testDeleteNotAuthorized()
    {
        Configure::write('CA.Models.articles', 'Articles');

        $this->delete('/admin/posttypes/articles/delete/1');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin');
    }

    /**
     * Test if exception is called if the posttype does not exist.
     *
     * @return void
     */
    public function testDeleteNoPostType()
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

        $this->delete('/admin/posttypes/articles/delete/1');

        $this->assertResponseFailure();
    }

    /**
     * Test delete request on registered posttype.
     *
     * @return void
     */
    public function testDeleteWithPostType()
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

        Configure::write('CA.Models.articles', 'Articles');

        $articles = TableRegistry::get('Articles');


        $this->assertEquals(3, $articles->find()->count());

        $this->delete('/admin/posttypes/articles/delete/1');

        $this->assertResponseSuccess();

        $this->assertEquals(2, $articles->find()->count());
    }
}
