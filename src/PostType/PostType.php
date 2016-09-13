<?php

namespace Bakkerij\CakeAdmin\PostType;

use Cake\Core\Exception\Exception;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

class PostType
{

    /**
     * PostType name
     *
     * @var string
     */
    protected $_name;

    /**
     * Model name
     *
     * @var string
     */
    protected $_model;

    /**
     * Slug name
     *
     * @var
     */
    protected $_slug;

    /**
     * Table instance
     *
     * @var Table
     */
    protected $_table;

    /**
     * Listed in menu
     *
     * @var bool
     */
    protected $_menu;

    /**
     * Description
     *
     * @var string
     */
    protected $_description;

    /**
     * List of actions
     *
     * @var array
     */
    protected $_actions = [
        'index' => true,
        'view' => true,
        'add' => true,
        'edit' => true,
        'delete' => true
    ];

    /**
     * Table columns
     *
     * @var array
     */
    protected $_columns;

    /**
     * Form fields
     *
     * @var array
     */
    protected $_fields;

    /**
     * PostType constructor.
     */
    public function __construct()
    {

        $this->initialize();
    }

    /**
     * Initialize the PostType.
     *
     * This method can be overridden in the PostType implementation.
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Returns the model name or sets a new one
     *
     * @param string|null $model Model name.
     * @return string
     */
    public function model($model = null)
    {
        if ($model) {
            $this->_model = $model;
        }
        return $this->_model;
    }

    /**
     * Returns the name or sets a new one
     *
     * @param string|null $name Name.
     * @return string
     */
    public function name($name = null)
    {
        if ($name) {
            $this->_name = $name;
        }
        if(!$this->_name) {
            $this->_name = $this->table()->alias();
        }
        return $this->_name;
    }

    /**
     * Returns the alias or sets a new one
     *
     * @param string|null $alias Alias.
     * @return string
     */
    public function alias($alias = null)
    {
        return $this->name($alias);
    }

    /**
     * Returns the PostType slug or sets a new one
     *
     * @param string|null $slug Slug
     * @return string
     */
    public function slug($slug = null)
    {
        if($slug) {
            $this->_slug = Text::slug($slug);
        }
        if(!$this->_slug) {
            $this->_slug = Text::slug($this->name());
        }
        return $this->_slug;
    }

    /**
     * Returns the menu state or sets a new one
     *
     * If the PostType should not be presented in the menu,
     * the value should be `false`. Default `true`.
     *
     * @param bool|null $menu Menu state
     * @return bool
     */
    public function menu($menu = null)
    {
        if($menu) {
            $this->_menu = (bool) $menu;
        }
        if(!$this->_menu) {
            $this->_menu = true;
        }
        return $this->_menu;
    }

    /**
     * Returns the description or sets a new one
     *
     * @param string|null $description Description
     * @return bool|null|string
     */
    public function description($description = null)
    {
        if($description) {
            $this->_description = $description;
        }
        if(!$this->_description) {
            $this->_description = true;
        }
        return $this->_description;
    }

    /**
     * Returns the action state or sets a new one
     *
     * @param string $action Action name like `index` or `add`
     * @param bool|null $enabled State of action like `true` or `false`
     * @return bool
     */
    public function action($action, $enabled = null)
    {
        if(is_array($action)) {
            foreach($action as $key => $value) {
                $this->action($key, $value);
            }
        }

        if($enabled !== null) {
            $this->_actions[$action] = (bool) $enabled;
        }
        if(!array_key_exists($action, $this->_actions)) {
            $this->_actions[$action] = true;
        }
        return $this->_actions[$action];
    }

    /**
     * Returns list of actions. Actions can be set using `actions()`
     *
     * @return array
     */
    public function actions()
    {
        return $this->_actions;
    }

    /**
     * Returns the filters or sets a new one
     *
     * @return void
     */
    public function filter()
    {
        throw new Exception("Not implemented yet");
    }

    /**
     * Returns the tables columns or sets new one
     *
     * @param array|null $columns Columns
     * @return array
     */
    public function tableColumns(array $columns = null)
    {
        if($columns) {
            $this->_columns = $this->_normalizeTableColumns($columns);
        }
        if(!$this->_columns) {
            $this->_columns = $this->_generateTableColumns();
        }
        return $this->_columns;
    }

    /**
     * Returns the forms fields or sets new one
     *
     * @param array|null $fields Fields
     * @return array
     */
    public function formFields(array $fields = null)
    {
        if($fields) {
            $this->_fields = $this->_normalizeFormFields($fields);
        }
        if(!$this->_fields) {
            $this->_fields = $this->_generateFormFields();
        }
        return $this->_fields;
    }

    /**
     * Returns the table instance or sets a new one
     *
     * @param Table|null $table Table
     * @return Table
     */
    public function table($table = null)
    {
        if($table) {
            $this->_table = $table;
        }
        if(!$this->_table) {
            $this->_table = TableRegistry::get($this->model());
        }
        return $this->_table;
    }

    /**
     * Normalizes array with table columns.
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

    /**
     * Normalizes array with form fields.
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
     * Generates an array with table columns from the model.
     *
     * @return array
     */
    protected function _generateTableColumns()
    {
        $table = $this->table();
        $schema = $table->schema();

        $columns = [];

        $pk = $schema->primaryKey();
        $columns[] = reset($pk);
        $columns[] = $table->displayField();

        if($table->hasBehavior('Timestamp')) {
            if($schema->column('created')) {
                $columns[] = 'created';
            }
            if($schema->column('modified')) {
                $columns[] = 'modified';
            }
        }

        return $this->_normalizeTableColumns($columns);
    }

    /**
     * Generates an array with form fields from the model.
     *
     * @return array
     */
    protected function _generateFormFields()
    {
        $table = $this->table();
        $schema = $table->schema();

        $fields = $schema->columns();

        return $this->_normalizeFormFields($fields);
    }

}