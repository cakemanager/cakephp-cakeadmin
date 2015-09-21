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

use Cake\Core\Configure;
use Cake\Network\Http\Client;
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
        $http = new Client(['host' => Configure::read('CA.Api')]);

        $response = $http->get('dashboards/posts.json')->json;

        $data = $response['data'];

        $this->set('data', (isset($data) ? $data : []));
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
                'url' => 'http://cakemanager.org/docs/cakeadmin/1.0/',
                'description' => 'Documentation about the CakeAdmin Plugin.'
            ],
            'Quick Start Tutorial' => [
                'url' => 'http://cakemanager.org/docs/cakeadmin/1.0/tutorials-and-examples/quick-start/',
                'description' => 'Short tutorial about how to install the CakeAdmin Plugin',
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
        $http = new Client(['host' => Configure::read('CA.Api')]);

        $response = $http->get('dashboards/resources.json')->json;

        $data = $response['data'];

        $this->set('data', $data);
    }

    /**
     * Plugins method
     *
     * @return void
     */
    public function plugins()
    {
        $http = new Client(['host' => Configure::read('CA.Api')]);

        $response = $http->get('dashboards/plugins.json')->json;

        $data = $response['data'];

        $this->set('data', $data);
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
