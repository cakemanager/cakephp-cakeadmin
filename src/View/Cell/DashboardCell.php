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
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeAdmin\View\Cell;

use Cake\Utility\Xml;
use Cake\View\Cell;

/**
 * Dashboard cell
 */
class DashboardCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Welcome method
     *
     * @return void
     */
    public function welcome()
    {
        $this->set('welcome', "Welcome to your CakeAdmin admin panel.");
    }

    /**
     * Latest Posts method.
     *
     * @return void
     */
    public function latestPosts()
    {
        $rss = file_get_contents('http://cakemanager.org/rss', false);

        if ($rss) {
            $xml = Xml::toArray(Xml::build($rss));
            $data = $xml['rss']['channel']['item'];
        }

        $this->set('posts', (isset($data) ? $data : []));
    }

    /**
     * Getting Started method
     *
     * @return void
     */
    public function gettingStarted()
    {
        $links = [
            'CakeManager Docs' => [
                'url' => 'http://cakemanager.org/docs/1.0/',
                'description' => 'Documentation about the CakeManager Plugin.'
            ],
            'Quick Start Tutorial' => [
                'url' => 'http://cakemanager.org/docs/1.0/tutorials-and-examples/quick-start/',
                'description' => 'Short tutorial about how to install the CakeManager',
            ]
        ];

        $this->set('list', $links);
    }

    /**
     * Getting Help method
     *
     * @return void
     */
    public function gettingHelp()
    {
        $links = [
            'CakeManager Website' => [
                'url' => 'http://cakemanager.org/',
                'description' => 'Website of the CakeManager Team. Here you can find everything about us and our plugins.'
            ],
            'Gitter' => [
                'url' => 'https://gitter.im/cakemanager/cakephp-cakemanager',
                'description' => 'Chat Tool for GitHub to talk about issues and new features.',
            ],
            'GitHub' => [
                'url' => 'https://github.com/cakemanager/cakephp-cakemanager/issues',
                'description' => 'When there\'s something wrong, please open a new issue!',
            ],
            'CakeManager Docs' => [
                'url' => 'http://cakemanager.org/docs/1.0/',
                'description' => 'Documentation about the CakeManager Plugin.',
            ],
            'CakePHP Utils Plugin Docs' => [
                'url' => 'http://cakemanager.org/docs/utils/1.0/',
                'description' => 'Documentation about the Utils Plugin.',
            ],
        ];

        $this->set('list', $links);
    }

    /**
     * Plugins method
     *
     * @return void
     */
    public function plugins()
    {
        $links = [
            'Utils' => [
                'url' => 'https://github.com/cakemanager/cakephp-utils',
                'description' => 'Utilities for Cake 3.x.'
            ],
            'Who Is Online' => [
                'url' => 'https://github.com/cakemanager/cakephp-whosonline',
                'description' => 'Plugin to follow your users on your app.'
            ],
            'PostTypes' => [
                'url' => 'https://github.com/cakemanager/cakephp-posttypes',
                'description' => 'Plugin to create dynamic CRUD for your admin-panel.'
            ],
            'Settings' => [
                'url' => 'https://github.com/cakemanager/cakephp-settings',
                'description' => 'Plugin to save settings in your database and manage them.'
            ],
        ];

        $this->set('list', $links);
    }

    /**
     * About Us method
     *
     * @return void
     */
    public function aboutUs()
    {
        
    }
}
