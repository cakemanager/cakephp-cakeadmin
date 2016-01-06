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
     * Controller
     *
     * @var Controller
     */
    public $controller = null;

    /**
     * Initialize component.
     *
     * @param array $config Configuration.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->setController($this->_registry->getController());

        $this->_registerPostTypesFromConfigure();

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
            'aliasLc' => lcfirst(Inflector::humanize(pluginSplit($model)[1])),
            'singularAlias' => ucfirst(Inflector::singularize(Inflector::humanize(pluginSplit($model)[1]))),
            'singularAliasLc' => lcfirst(Inflector::singularize(Inflector::humanize(pluginSplit($model)[1]))),
            'description' => null,
            'actions' => [
                'index' => true,
                'add' => true,
                'edit' => true,
                'view' => true,
                'delete' => true,
            ],
            'filters' => [],
            'contain' => [],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => false,
            'formFields' => false,
        ];
        $options = array_merge($_defaults, $options);

        if (!$options['tableColumns']) {
            $options['tableColumns'] = $this->_generateTableColumns($model);
        }
        if (!$options['formFields']) {
            $options['formFields'] = $this->_generateFormFields($model);
        }

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
     * getOption
     *
     * Return single option, or all options per PostType.
     *
     * @param string $name Name of the PostType.
     * @param string $option String of the named option.
     * @return array|bool
     */
    public function getOption($name, $option = null)
    {
        $postTypes = Configure::read('CA.PostTypes');

        if (array_key_exists($name, $postTypes)) {
            if ($option) {
                if (array_key_exists($option, $postTypes[$name])) {
                    return $postTypes[$name][$option];
                }
            }
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
     * @return void
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
     * @return void
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
                        'prefix' => 'admin',
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

    /**
     * _registerPostTypesFromConfigure
     *
     * Registers the PostTypes added via the Configure-class.
     * The PostType should be added via `CA.Models`.
     *
     * @return void
     */
    protected function _registerPostTypesFromConfigure()
    {
        $configure = Configure::read('CA.Models');

        foreach ($configure as $name => $model) {
            $this->register($model);
        }
    }

    /**
     * If no tablecolumns are given, this method will be called to generate a list of tablecolumns.
     *
     * @param \Cake\ORM\Table $model Model to rely on.
     * @return array
     */
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

    /**
     * If no formfields are given, this method will be called to generate a list of formfields.
     *
     * @param \Cake\ORM\Table $model Model to rely on.
     * @return array
     */
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

    /**
     * Normalizes the formfields-array.
     *
     * @param array $fields Fields to normalize.
     * @return array
     */
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

    /**
     * Normalizes the tablecolumns-array.
     *
     * @param array $columns Columns to normalize.
     * @return array
     */
    protected function _normalizeTableColumns($columns)
    {
        $_defaults = [
            'get' => false,
            'before' => '',
            'after' => '',
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
}
