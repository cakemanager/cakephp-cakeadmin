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
namespace CakeAdmin\View\Helper;

use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\View;

/**
 * PostTypes helper
 */
class PostTypesHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * PostType configurations.
     *
     * @var array
     */
    protected $_type = null;

    public $helpers = [
        'Html',
        'Form',
        'Paginator',
        'Utils.Search'
    ];

    /**
     * Data to use.
     *
     * @var array
     */
    protected $_data = null;

    /**
     * type
     *
     * Setter and getter for $_type.
     *
     * @param array $type Type.
     * @return array|null
     */
    public function type($type = null)
    {
        if ($type) {
            $this->_type = $type;
        }
        return $this->_type;
    }

    /**
     * data
     *
     * Setter and getter for $_data.
     *
     * @param array $data Data.
     * @return array|null
     */
    public function data($data = null)
    {
        if ($data) {
            $this->_data = $data;
        }
        return $this->_data;
    }

    /**
     * header
     *
     * Header of the page.
     *
     * ### Options
     * - `before` - Html before the header.
     * - `after` - Html after the header.
     *
     * @param array $options Options.
     * @return string
     */
    public function header($options = [])
    {
        $_options = [
            'before' => '<h3>',
            'after' => '</h3>'
        ];

        $options = array_merge($_options, $options);

        return $options['before'] . h($this->_type['alias']) . $options['after'];
    }

    /**
     * indexButton
     *
     * An `index`-button with a link to the PostType List.
     *
     * ### Options
     * - `before` - Html before the button.
     * - `after` - Html after the button.
     *
     * The link will be created via the HtmlHelper.
     *
     * @param array $options Options.
     * @return string
     */
    public function indexButton($options = [])
    {
        $_options = [
            'before' => 'All ',
            'after' => '',
        ];

        $options = array_merge($_options, $options);

        $string = $options['before'] . h(Inflector::singularize($this->_type['alias'])) . $options['after'];
        return $this->Html->link($string, ['action' => 'add', 'type' => $this->_type['slug']]);
    }

    /**
     * addButton
     *
     * An `add`-button with a link to add a new PostType Entity.
     *
     * ### Options
     * - `before` - Html before the button.
     * - `after` - Html after the button.
     *
     * The link will be created via the HtmlHelper.
     *
     * @param array $options Options.
     * @return string
     */
    public function addButton($options = [])
    {
        $_options = [
            'before' => 'New ',
            'after' => '',
        ];

        $options = array_merge($_options, $options);

        $string = $options['before'] . h(Inflector::singularize($this->_type['alias'])) . $options['after'];
        return $this->Html->link($string, ['action' => 'add', 'type' => $this->_type['slug']]);
    }

    /**
     * searchFilter
     *
     * Filter-form to search with.
     *
     * @param $searchFilters Filter-data.
     * @param array $options Options.
     * @return null|string
     */
    public function searchFilter($searchFilters, $options = [])
    {
        $_options = [];

        $options = array_merge($_options, $options);

        return ($searchFilters ? $this->Search->filterForm($searchFilters) : null);
    }

    /**
     * tableHead
     *
     * Generates the head of the table (all columns).
     *
     * ### Options
     * - `beforeActionHead` - Html before the action-column.
     * - `afterActionHead` - Html after the action-column.
     * - `actionsLabel` - Label of `Actions`.
     *
     * @param array $options Options.
     * @return string
     */
    public function tableHead($options = [])
    {
        $_options = [
            'beforeActionHead' => '<td class="actions">',
            'afterActionHead' => '</td>',
            'actionsLabel' => __('Actions'),
        ];

        $options = array_merge($_options, $options);

        $html = '';

        $html .= '<tr>';

        foreach ($this->type()['tableColumns'] as $column => $opt):
            $html .= '<th>';
            $html .= $this->Paginator->sort($column);
            $html .= '</th>';
        endforeach;

        $html .= $options['beforeActionHead'] . $options['actionsLabel'] . $options['afterActionHead'];
        $html .= '</tr>';

        return $html;
    }

    /**
     * tableBody
     *
     * Generates the head of the table (all columns).
     *
     * ### Options
     * - `beforeActionBody` - Html before the actions-cell.
     * - `afterActionBody` - Html after the actions-cell.
     * - `viewLabel` - Label for the view-button.
     * - `editLabel` - Label for the edit-button.
     * - `deleteLabel` - Label for the delete-button.
     *
     * @param array $options Options.
     * @return string
     */
    public function tableBody($options = [])
    {
        $_options = [
            'beforeActionBody' => '<td class="actions">',
            'afterActionBody' => '</td>',
            'viewLabel' => __('View'),
            'editLabel' => __('Edit'),
            'deleteLabel' => __('Delete'),
        ];

        $options = array_merge($_options, $options);

        $html = '';

        foreach ($this->_data as $item):
            $html .= '<tr>';

            foreach ($this->_type['tableColumns'] as $column => $opt):
                $html .= '<td>';
                $html .= $opt['before'];
                $html .= Hash::get($item->toArray(), $opt['get']);
                $html .= $opt['after'];
                $html .= '</td>';
            endforeach;

            $html .= $options['beforeActionBody'];

            $html .= $this->Html->link($options['viewLabel'], [
                'action' => 'view',
                'type' => $this->type()['slug'],
                $item->get('id')
            ]). ' ';

            $html .= $this->Html->link($options['editLabel'], [
                'action' => 'edit',
                'type' => $this->type()['slug'],
                $item->get('id')
            ]). ' ';

            $html .= $this->Form->postLink($options['deleteLabel'], [
                'action' => 'delete',
                'type' => $this->type()['slug'],
                $item->get('id')
            ], [
                'confirm' => __('Are you sure you want to delete # {0}?', $item->get('id'))
            ]);

            $html .= $options['afterActionBody'];

            $html .= '</tr>';
        endforeach;

        return $html;
    }

    /**
     * createForm
     *
     * Initializer for a form.
     *
     * @param \Cake\ORM\Entity $entity Entity.
     * @param array $options Options.
     * @return mixed
     */
    public function createForm($entity, $options = [])
    {
        $options = array_merge($this->type()['formFields']['_create'], $options);

        return $this->Form->create($entity, $options);
    }

    /**
     * fieldset
     *
     * Generates a fieldset,
     *
     * ### Options
     * - `beforeLegend` - Html before the legend.
     * - `afterLegend` - Html after the legend.
     * - `label` - Label at top of the fieldset.
     * - `on` - Array with the validations (`both`, `add` or `edit`).
     *
     * @param array $options Options.
     * @return string
     */
    public function fieldset($options = [])
    {
        $_options = [
            'beforeLegend' => '<legend>',
            'afterLegend' => '</legend>',
            'label' => __('Add '),
            'on' => ['both']
        ];

        $options = array_merge($_options, $options);

        $html = '';

        $html .= $options['beforeLegend'] . $options['label'] . $this->type()['alias'] . $options['afterLegend'];

        foreach ($this->type()['formFields'] as $field => $opt):
            if (substr($field, 0, 1) !== '_') {
                if (in_array($opt['on'], $options['on'])) {
                    echo $this->Form->input($field, $opt);
                }
            }
        endforeach;

        return $html;
    }

    /**
     * submitForm
     *
     * Submitbutton for the form.
     *
     * ### Options
     * - `submitLabel` - Label to use.
     * - `options` - Options for the button.
     *
     * @param array $options Options.
     * @return mixed
     */
    public function submitForm($options = [])
    {
        $_options = [
            'submitLabel' => __('Submit'),
            'options' => [],
        ];

        $options = array_merge($_options, $options);

        return $this->Form->button($options['submitLabel'], $options['options']);
    }

    /**
     * endForm
     *
     * Ends the form.
     *
     * @return mixed
     */
    public function endForm()
    {
        return $this->Form->end();
    }

}
