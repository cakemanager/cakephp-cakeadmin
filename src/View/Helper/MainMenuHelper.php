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

use Cake\View\Helper;
use Utils\View\Helper\MenuBuilderInterface;

/**
 * Menu helper
 *
 * This helper is a template to build up the main menu.
 * Thats the `main` area.
 *
 */
class MainMenuHelper extends Helper implements MenuBuilderInterface
{
    /**
     * Used helpers
     *
     * @var array
     */
    public $helpers = [
        'Html'
    ];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * afterMenu
     *
     * Method after the menu has been build.
     *
     * @param array $menu The menu items.
     * @param array $options Options.
     * @return string
     */
    public function afterMenu($menu = [], $options = [])
    {
        return '';
    }

    /**
     * afterSubItem
     *
     * Method after a submenu item has been build.
     *
     * @param array $item The menu items.
     * @param array $options Options.
     * @return string
     */
    public function afterSubItem($item = [], $options = [])
    {
        return '';
    }

    /**
     * beforeMenu
     *
     * Method before the menu has been build.
     *
     * @param array $menu The menu items.
     * @param array $options Options.
     * @return string
     */
    public function beforeMenu($menu = [], $options = [])
    {
        return '';
    }

    /**
     * afterSubItem
     *
     * Method before a submenu item has been build.
     *
     * @param array $item The menu items.
     * @param array $options Options.
     * @return string
     */
    public function beforeSubItem($item = [], $options = [])
    {
        return '';
    }

    /**
     * item
     *
     * Method to build an menu item.
     *
     * @param array $item The menu item.
     * @param array $options Options.
     * @return string
     */
    public function item($item = [], $options = [])
    {
        $html = '<li ' . ($item['active'] ? 'class="active"' : '') . '>' .
            $this->Html->link(__($item['title']), $item['url']) . '</li>';
        return $html;
    }

    /**
     * item
     *
     * Method to build an submenu item.
     *
     * @param array $item The menu item.
     * @param array $options Options.
     * @return string
     */
    public function subItem($item = [], $options = [])
    {
        return '';
    }

    /**
     * beforeItem
     *
     * Method before an item has been build.
     *
     * @param array $item The menu item.
     * @param array $options Options.
     * @return string
     */
    public function beforeItem($item = [], $options = [])
    {
        return '';
    }

    /**
     * afterItem
     *
     * Method after an item has been build.
     *
     * @param array $item The menu item.
     * @param array $options Options.
     * @return string
     */
    public function afterItem($item = [], $options = [])
    {
        return '';
    }
}
