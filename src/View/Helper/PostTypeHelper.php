<?php
namespace Bakkerij\CakeAdmin\View\Helper;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\View;

/**
 * PostType helper
 */
class PostTypeHelper extends Helper
{

    /**
     * Helpers.
     *
     * @var array
     */
    public $helpers = [
        'Html',
        'Form'
    ];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Returns name
     *
     * Can be returned in two forms:
     *
     * - singular (calling `$this->PostType->name('singular')`)
     * - plural (calling `$this->PostType->name('plural')`)
     *
     * @param string|null $form Form
     * @return mixed|string
     */
    public function name($form = null)
    {
        $name = $this->getPostType('name');

        if ($form === 'singular') {
            return Inflector::singularize($name);
        }
        if ($form === 'plural') {
            return Inflector::pluralize($name);
        }
        return $name;
    }

    /**
     * Returns slug
     *
     * @return string
     */
    public function slug()
    {
        return $this->getPostType('slug');
    }

    public function tableColumns()
    {
        return $this->getPostType('tableColumns');
    }

    public function indexLink()
    {
        return $this->Html->link(
            __('List'),
            [
                '_name' => 'cakeadmin:posttype:index',
                'type' => $this->slug(),
            ]
        );
    }

    public function viewLink(EntityInterface $item)
    {
        if(!$this->getPostType()->action('view')) {
            return;
        }

        return $this->Html->link(
            __('View'),
            [
                '_name' => 'cakeadmin:posttype:view',
                'type' => $this->slug(),
                $item->get('id')
            ]
        );
    }

    public function editLink(EntityInterface $item)
    {
        if(!$this->getPostType()->action('edit')) {
            return;
        }

        return $this->Html->link(
            __('Edit'),
            [
                '_name' => 'cakeadmin:posttype:edit',
                'type' => $this->slug(),
                $item->get('id')
            ]
        );
    }

    public function deleteLink(EntityInterface $item)
    {
        if(!$this->getPostType()->action('delete')) {
            return;
        }

        return $this->Form->postLink(
            __('Delete'),
            [
                '_name' => 'cakeadmin:posttype:delete',
                'type' => $this->slug(),
                $item->get('id')
            ],
            [
                'confirm' => __('Are you sure you want to delete # {0}?', $item->get('id'))
            ]
        );
    }

    /**
     * Getter for PostType values.
     *
     * @param string|null $key Key like `name` or `slug`. Leave `null` to get full PostType
     * @return mixed
     */
    protected function getPostType($key = null)
    {
        $postType = $this->config('data');
        if ($key) {
            return call_user_func([$postType, $key]);
        }
        return $postType;
    }
}
