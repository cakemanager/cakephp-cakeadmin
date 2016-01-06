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
namespace CakeAdmin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AdministratorsFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => [
            'type' => 'integer',
            'length' => 11,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => '',
            'autoIncrement' => true,
            'precision' => null
        ],
        'email' => [
            'type' => 'string',
            'length' => 50,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'password' => [
            'type' => 'string',
            'length' => 255,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'cakeadmin' => [
            'type' => 'integer',
            'length' => 11,
            'unsigned' => false,
            'null' => true,
            'default' => '1',
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'request_key' => [
            'type' => 'string',
            'length' => 255,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'created' => [
            'type' => 'datetime',
            'length' => null,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null
        ],
        'modified' => [
            'type' => 'datetime',
            'length' => null,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null
        ],
        '_constraints' => [
            'primary' => [
                'type' => 'primary',
                'columns' => ['id'],
                'length' => []
            ],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'email' => 'bob@cakeplugins.org',
            'password' => '12345',
            'cakeadmin' => 1,
            'created' => '2015-12-18 15:37:51',
            'modified' => '2015-12-18 15:37:51'
        ],
        [
            'id' => 2,
            'email' => 'unknown@cakeplugins.org',
            'password' => '12345',
            'cakeadmin' => 0,
            'created' => '2015-12-18 15:37:51',
            'modified' => '2015-12-18 15:37:51'
        ],
    ];
}
