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
namespace CakeAdmin\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * PostTypes component
 */
class PostTypesComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'table' => [
            'ignoredColumns' => [
                'password'
            ],
            'max' => 2
        ],
        'form' => [
            'ignoredFields' => [
                'created_by',
                'modified_by',
                'created',
                'modified'
            ]
        ]
    ];

    /**
     * Components
     *
     * @var array
     */
    public $components = [
        'CakeAdmin.ModelManager'
    ];

    /**
     * Controller
     *
     * @var Controller
     */
    public $controller = null;

    public function initialize(array $config)
    {
        $this->setController($this->_registry->getController());

        $this->_registerPostTypesFromConfigure();

//        $this->_registerPostTypesFromTables();

        $this->_addMenuItems();
    }

    /**
     * setController
     *
     * Setter for the Controller property.
     *
     * @param \Cake\Controller\Controller $controller Controller.
     * @return void
     */
    public function setController($controller)
    {
        $this->Controller = $controller;
    }

    /**
     * beforeFilter
     *
     * BeforeFilter event.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter($event)
    {
    }

    /**
     * beforeRender
     *
     * beforeRender event.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeRender($event)
    {

    }

    /**
     * register
     *
     * Registers a new PostType.
     * The default options will be merged with the given options.
     * After that, the type will be saved in the Configure-class.
     *
     * @param string $model Model to make a PostType off.
     * @param array $options Options.
     * @return void
     */
    public function register($model, $options = [])
    {
        $postTypes = Configure::read('CA.PostTypes');

        $_defaults = [
            'model' => $model,
            'menu' => true,
            'menuWeight' => 20,
            'slug' => lcfirst(Inflector::slug(pluginSplit($model)[1])),
            'name' => ucfirst(Inflector::slug(pluginSplit($model)[1])),
            'alias' => ucfirst(Inflector::humanize(pluginSplit($model)[1])),
            'description' => null,
            'filters' => [],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => $this->_generateTableColumns($model),
            'formFields' => $this->_generateFormFields($model),
        ];
        $options = array_merge($_defaults, $options);

        # model is able to disable the PostType to register by returning false
        $modelOptions = $this->_getOptionsFromModel($options['model']);
        if ($modelOptions === false) {
            return;
        }
        $options = array_merge($options, $modelOptions);

        if ($options['formFields']) {
            $options['formFields'] = $this->_normalizeFormFields($options['formFields']);
        }

        if ($options['tableColumns']) {
            $options['tableColumns'] = $this->_normalizeTableColumns($options['tableColumns']);
        }

        $postTypes[$options['slug']] = $options;

        Configure::write('CA.PostTypes', $postTypes);
    }

    /**
     * getOptions
     *
     * Returns all options of a specific PostType.
     *
     * @param string $name Name of the PostType.
     * @return array|bool
     */
    public function getOptions($name)
    {
        $postTypes = Configure::read('CA.PostTypes');

        if (array_key_exists($name, $postTypes)) {
            return $postTypes[$name];
        }
        return false;
    }

    /**
     * getFormFields
     *
     * Returns a list with the formfields of the type.
     *
     * @param string $name Name of the PostType.
     * @return array
     */
    public function getFormFields($name)
    {

    }

    /**
     * getTableColumns
     *
     * Returns a list with the tablecolumns of the type.
     *
     * @param string $name Name of the PostType.
     * @return array
     */
    public function getTableColumns($name)
    {

    }

    /**
     * _addMenuItems
     *
     * Adds menu-items of every PostType to the 'main' menu.
     *
     * @return void
     */
    protected function _addMenuItems()
    {
        $postTypes = Configure::read('CA.PostTypes');

        $this->Controller->Menu->area('main');

        foreach ($postTypes as $name => $options) {
            if ($options['menu']) {
                $this->Controller->Menu->add($options['alias'], [
                    'url' => [
                        'prefix' => false,
                        'plugin' => 'CakeAdmin',
                        'controller' => 'PostTypes',
                        'action' => 'index',
                        'type' => $options['slug']
                    ],
                    'weight' => $options['menuWeight']
                ]);
            }
        }
    }

    /**
     * _getOptionsFromModel
     *
     * Returns a list of options token from the model.
     *
     * @param string $model The model to use.
     * @return array|null|bool
     */
    protected function _getOptionsFromModel($model)
    {
        $model = TableRegistry::get($model);

        if (method_exists($model, 'postType')) {
            $result = $model->postType();
            if ($result) {
                $result['table'] = $model->table();
            }
            return $result;
        }
        if (property_exists($model, 'postType')) {
            $result = $model->postType;
            if ($result) {
                $result['table'] = $model->table();
            }
            return $result;
        }
        return [];
    }

    protected function _registerPostTypesFromConfigure()
    {
        $configure = Configure::read('CA.Models');

        foreach ($configure as $name => $model) {
            $this->register($model);
        }
    }

    /**
     * _registerPostTypesFromTables
     *
     * Registers PostTypes of all tables wich are not presented in a registerd PostType.
     *
     * @return void
     */
    protected function _registerPostTypesFromTables()
    {
        # list of tables
        $tables = ConnectionManager::get('default')->schemaCollection()->listTables();

        $ignoredTables = (array)Configure::read('CA.IgnoredTables');

        foreach ($tables as $table) {
            if (!$this->__isTableUsedByPostType($table)) {
                if (!in_array($table, $ignoredTables)) {
                    $this->register(Inflector::camelize($table));
                }
            }
        }
    }

    protected function _generateTableColumns($model)
    {
        $model = TableRegistry::get($model);
        $columns = ConnectionManager::get('default')->schemaCollection()->describe($model->table())->columns();

        $result = [];
        $counter = 0;
        $max = 2;

        if (in_array('id', $columns)) {
            $result['id'] = [];
            unset($columns['id']);
        }

        foreach ($columns as $column) {
            if ($counter < $max) {
                $result[$column] = [];
                unset($columns[$column]);
                $counter++;
            }
        }

        if (in_array('created', $columns)) {
            $result['created'] = [];
        }

        return $result;
    }

    protected function _generateFormFields($model)
    {
        $model = TableRegistry::get($model);
        $columns = ConnectionManager::get('default')->schemaCollection()->describe($model->table())->columns();

        $ignoredFields = [
            'created',
            'modified',
            'created_by',
            'modified_by',
            'password'
        ];

        $result = [];

        foreach ($columns as $column) {
            if (!in_array($column, $ignoredFields)) {
                $result[$column] = [];
            }
        }
        return $result;
    }

    protected function _normalizeFormFields($fields)
    {
        $_options = [
            'on' => 'both'
        ];

        $_defaults = [
            '_create' => $_options
        ];

        $result = [];

        $result['_create'] = $_defaults['_create'];

        foreach ($fields as $name => $options) {
            if (is_array($options)) {
                $result[$name] = array_merge($_options, $options);
            } else {
                $result[$options] = $_options;
            }
        }
        return $result;
    }

    protected function _normalizeTableColumns($columns)
    {
        $_defaults = [
            'get' => false
        ];
        $result = [];

        foreach ($columns as $name => $options) {
            if (is_array($options)) {
                $_defaults['get'] = $name;
                $result[$name] = array_merge($_defaults, $options);
            } else {
                $_defaults['get'] = $options;
                $result[$options] = $_defaults;
            }
        }
        return $result;
    }

    /**
     * __isTableUsedByPostType
     *
     * Checks if the table is already used by any registered PostType.
     * If a table is used, `true` will be returned. Else, `false` will be returned.
     *
     * @param string $tableName Name of the table.
     * @return bool
     */
    private function __isTableUsedByPostType($tableName)
    {
        $postTypes = Configure::read('CA.PostTypes');
        foreach ($postTypes as $name => $options) {
            if ((array_key_exists('table', $options)) && ($options['table'] === $tableName)) {
                return true;
            }
        }
        return false;
    }


}
