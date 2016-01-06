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

use CakeAdmin\Controller\Component\PostTypesComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;

/**
 * CakeAdmin\Controller\Component\PostTypesComponent Test Case
 */
class PostTypesComponentTest extends TestCase
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
        'plugin.cake_admin.books',
        'core.authors'
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
        $this->PostTypes = $this->getMock(
            'CakeAdmin\Controller\Component\PostTypesComponent',
            ['_registerPostTypesFromConfigure', '_addMenuItems'],
            [$collection]
        );
        $this->Controller = $this->getMock('Cake\Controller\Controller', ['redirect']);
        $this->PostTypes->setController($this->Controller);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        Configure::write('CA.PostTypes', []);

        unset($this->PostTypes);

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
        $PostType = $this->getMock(
            'CakeAdmin\Controller\Component\PostTypesComponent',
            ['_registerPostTypesFromConfigure', '_addMenuItems'],
            [$collection]
        );

        $PostType->expects($this->once())
            ->method('_registerPostTypesFromConfigure')
            ->will($this->returnValue(true));

        $PostType->expects($this->once())
            ->method('_addMenuItems')
            ->will($this->returnValue(true));

        $PostType->initialize([]);
    }

    /**
     * Test setController method.
     *
     * @return void
     */
    public function testSetController()
    {
        $this->PostTypes->setController('No Controller');

        $this->assertEquals('No Controller', $this->PostTypes->Controller);
    }

    /**
     * Test if the PostType will have all needed default options.
     *
     * @return void
     */
    public function testRegisterDefaultOptions()
    {
        $this->assertEquals([], Configure::read('CA.PostTypes'));

        $this->PostTypes->register('Authors');

        $this->assertNotNull(Configure::read('CA.PostTypes'));

        $posttypes = Configure::read('CA.PostTypes');

        $expected = [
            'model' => 'Authors',
            'menu' => true,
            'menuWeight' => (int)20,
            'slug' => 'authors',
            'name' => 'Authors',
            'alias' => 'Authors',
            'aliasLc' => 'authors',
            'singularAlias' => 'Author',
            'singularAliasLc' => 'author',
            'description' => null,
            'actions' => [
                'index' => true,
                'add' => true,
                'edit' => true,
                'view' => true,
                'delete' => true
            ],
            'filters' => [],
            'contain' => [],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => [
                'id' => [
                    'get' => 'id',
                    'before' => '',
                    'after' => ''
                ],
                'name' => [
                    'get' => 'name',
                    'before' => '',
                    'after' => ''
                ]
            ],
            'formFields' => [
                '_create' => [
                    'on' => 'both'
                ],
                'id' => [
                    'on' => 'both'
                ],
                'name' => [
                    'on' => 'both'
                ]
            ]
        ];

        $this->assertArrayHasKey('authors', $posttypes);
        $this->assertEquals($expected, $posttypes['authors']);
    }

    /**
     * Test if all options are customizable.
     *
     * @return void
     */
    public function testRegisterCustomOptions()
    {
        $this->assertEquals([], Configure::read('CA.PostTypes'));

        $this->PostTypes->register('Authors', [
            'model' => 'CakeAdmin.Authors',
            'menu' => false,
            'menuWeight' => 25,
            'slug' => 'cake-authors',
            'name' => 'Cake Authors',
            'alias' => 'CakeAuthors',
            'aliasLc' => 'cakeauthors',
            'singularAlias' => 'Cake Author',
            'singularAliasLc' => 'cake author',
            'description' => 'Authors are owners of books.',
            'actions' => [
                'index' => false,
                'add' => false,
                'edit' => false,
                'view' => false,
                'delete' => false
            ],
            'filters' => [
                'name'
            ],
            'contain' => [
                'books'
            ],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => [
                'id',
                'name'
            ],
            'formFields' => [
                'id',
                'name'
            ]
        ]);

        $this->assertNotNull(Configure::read('CA.PostTypes'));

        $posttypes = Configure::read('CA.PostTypes');

        $expected = [
            'model' => 'CakeAdmin.Authors',
            'menu' => false,
            'menuWeight' => (int)25,
            'slug' => 'cake-authors',
            'name' => 'Cake Authors',
            'alias' => 'CakeAuthors',
            'aliasLc' => 'cakeauthors',
            'singularAlias' => 'Author',
            'singularAliasLc' => 'author',
            'description' => 'Authors are owners of books.',
            'actions' => [
                'index' => false,
                'add' => false,
                'edit' => false,
                'view' => false,
                'delete' => false
            ],
            'filters' => [
                (int)0 => 'name'
            ],
            'contain' => [
                (int)0 => 'books'
            ],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => [
                'id' => [
                    'get' => 'id',
                    'before' => '',
                    'after' => ''
                ],
                'name' => [
                    'get' => 'name',
                    'before' => '',
                    'after' => ''
                ]
            ],
            'formFields' => [
                '_create' => [
                    'on' => 'both'
                ],
                'id' => [
                    'on' => 'both'
                ],
                'name' => [
                    'on' => 'both'
                ]
            ],
            'singularAlias' => 'Cake Author',
            'singularAliasLc' => 'cake author'
        ];

        $this->assertArrayHasKey('cake-authors', $posttypes);
        $this->assertEquals($expected, $posttypes['cake-authors']);
    }

    /**
     * Test if options defined in the model will be used when registering a PostType.
     *
     * @return void
     */
    public function testRegisterModelOptions()
    {
        $this->assertEquals([], Configure::read('CA.PostTypes'));

        $this->PostTypes->register('Books');

        $this->assertNotNull(Configure::read('CA.PostTypes'));

        $posttypes = Configure::read('CA.PostTypes');

        $expected = [
            'model' => 'Books',
            'menu' => false,
            'menuWeight' => (int)25,
            'slug' => 'books',
            'name' => 'Cake Books',
            'alias' => 'CakeBooks',
            'aliasLc' => 'cakebooks',
            'singularAlias' => 'Book',
            'singularAliasLc' => 'book',
            'description' => 'Books are written by authors.',
            'actions' => [
                'index' => false,
                'add' => false,
                'edit' => false,
                'view' => false,
                'delete' => false
            ],
            'filters' => [
                (int)0 => 'title'
            ],
            'contain' => [
                (int)0 => 'authors'
            ],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => [
                'id' => [
                    'get' => 'id',
                    'before' => '',
                    'after' => ''
                ],
                'author_id' => [
                    'get' => 'author_id',
                    'before' => '',
                    'after' => ''
                ],
                'title' => [
                    'get' => 'title',
                    'before' => '',
                    'after' => ''
                ],
                'body' => [
                    'get' => 'body',
                    'before' => '',
                    'after' => ''
                ],
                'published' => [
                    'get' => 'published',
                    'before' => '',
                    'after' => ''
                ]
            ],
            'formFields' => [
                '_create' => [
                    'on' => 'both'
                ],
                'id' => [
                    'on' => 'both'
                ],
                'author_id' => [
                    'on' => 'both'
                ],
                'title' => [
                    'on' => 'both'
                ]
            ],
            'singularAlias' => 'Cake Book',
            'singularAliasLc' => 'cake book',
            'table' => 'books'
        ];

        $this->assertArrayHasKey('books', $posttypes);
        $this->assertEquals($expected, $posttypes['books']);
    }

    /**
     * Test if the options can be retrieved per PostType.
     *
     * @return void
     */
    public function testGetOption()
    {
        $this->assertEquals([], Configure::read('CA.PostTypes'));

        $this->PostTypes->register('Books');

        $this->assertNotNull(Configure::read('CA.PostTypes'));

        $this->assertEquals('Books are written by authors.', $this->PostTypes->getOption('books', 'description'));

        $expected = [
            'id' => [
                'get' => 'id',
                'before' => '',
                'after' => ''
            ],
            'author_id' => [
                'get' => 'author_id',
                'before' => '',
                'after' => ''
            ],
            'title' => [
                'get' => 'title',
                'before' => '',
                'after' => ''
            ],
            'body' => [
                'get' => 'body',
                'before' => '',
                'after' => ''
            ],
            'published' => [
                'get' => 'published',
                'before' => '',
                'after' => ''
            ]
        ];

        $this->assertEquals($expected, $this->PostTypes->getOption('books', 'tableColumns'));
    }

    /**
     * Test if all options can be retrieved per PostType when no key is used.
     *
     * @return void
     */
    public function testGetOptionWithoutKey()
    {
        $this->assertEquals([], Configure::read('CA.PostTypes'));

        $this->PostTypes->register('Books');

        $this->assertNotNull(Configure::read('CA.PostTypes'));

        $expected = [
            'model' => 'Books',
            'menu' => false,
            'menuWeight' => (int)25,
            'slug' => 'books',
            'name' => 'Cake Books',
            'alias' => 'CakeBooks',
            'aliasLc' => 'cakebooks',
            'singularAlias' => 'Book',
            'singularAliasLc' => 'book',
            'description' => 'Books are written by authors.',
            'actions' => [
                'index' => false,
                'add' => false,
                'edit' => false,
                'view' => false,
                'delete' => false
            ],
            'filters' => [
                (int)0 => 'title'
            ],
            'contain' => [
                (int)0 => 'authors'
            ],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => [
                'id' => [
                    'get' => 'id',
                    'before' => '',
                    'after' => ''
                ],
                'author_id' => [
                    'get' => 'author_id',
                    'before' => '',
                    'after' => ''
                ],
                'title' => [
                    'get' => 'title',
                    'before' => '',
                    'after' => ''
                ],
                'body' => [
                    'get' => 'body',
                    'before' => '',
                    'after' => ''
                ],
                'published' => [
                    'get' => 'published',
                    'before' => '',
                    'after' => ''
                ]
            ],
            'formFields' => [
                '_create' => [
                    'on' => 'both'
                ],
                'id' => [
                    'on' => 'both'
                ],
                'author_id' => [
                    'on' => 'both'
                ],
                'title' => [
                    'on' => 'both'
                ]
            ],
            'singularAlias' => 'Cake Book',
            'singularAliasLc' => 'cake book',
            'table' => 'books'
        ];

        $this->assertEquals($expected, $this->PostTypes->getOption('books'));
    }

    /**
     * Test if the getOption can handle a non-existing PostType and returns `false`.
     *
     * @return void
     */
    public function testGetOptionWithNoExisitingPostType()
    {
        $this->assertFalse($this->PostTypes->getOption('cake-books'));
    }
}
