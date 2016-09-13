<?php

namespace Bakkerij\CakeAdmin;

use Bakkerij\CakeAdmin\PostType\PostTypeRegistry;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class BaseCakeAdmin implements EventListenerInterface
{

    /**
     * Storage for the `addController` method
     *
     * @var array
     */
    protected $_controllerStorage;

    public function __construct()
    {
        $this->initialize();
    }

    public function initialize()
    {

    }

    /**
     * Register a PostType
     *
     * ### Example
     *
     * ```
     * // App
     * $this->registerPostType('Bookmarks');
     *
     * // Plugin
     * $this->registerPostType('MyPlugin.Bookmarks');
     * ```
     *
     * @param string $postType PostType
     * @return void
     */
    public function registerPostType($postType)
    {
        PostTypeRegistry::register($postType);
    }

    /**
     * Register a custom controller
     *
     * The route of the controller can be parsed in multiple ways.
     * Of course, you can parse an array like:
     *
     * ```
     * $this->addController('Custom Item', [
     *      'controller' => 'Custom',
     *      'action' => 'index'
     * ]);
     * ```
     *
     * Another way to parse the route is via a string. Some examples:
     *
     * ```
     * // Default example
     * $this->addController('Custom Item', 'Admin/Custom::index');
     *
     * // With plugin
     * $this->addController('Custom Item', 'MyPlugin.Admin/Custom::index');
     *
     * // Without prefix (Admin)
     * $this->addController('Custom Item', 'Custom::index');
     *
     * // Without action (default `index`)
     * $this->addController('Custom Item', 'Admin/Custom');
     * ```
     *
     * @param $alias
     * @param $route
     */
    public function addController($alias, $route)
    {
        if (is_string($route)) {
            $route = $this->__formatRoute($route);
        }

        Configure::write('CA.menu.main', array_merge(Configure::read('CA.menu.main'), [
            $alias => [
                'uri' => $route
            ]
        ]));
    }

    /**
     * Returns a list of events this object is implementing. When the class is registered
     * in an event manager, each individual method will be associated with the respective event.
     *
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents()
    {
        return [
            'CakeAdmin.Controller.startup' => 'startup',
            'CakeAdmin.Controller.beforeRedirect' => 'beforeRedirect',
            'CakeAdmin.Controller.beforeFilter' => 'beforeFilter',
            'CakeAdmin.Controller.beforeRender' => 'beforeRender',
            'CakeAdmin.Controller.shutdown' => 'shutdown',
        ];
    }

    /**
     * Event called method on startup.
     *
     * @param Event $event Event.
     */
    public function startup(Event $event)
    {
    }

    /**
     * Event called method on beforeRedirect.
     *
     * @param Event $event Event.
     */
    public function beforeRedirect(Event $event)
    {
    }

    /**
     * Event called method on beforeFilter.
     *
     * @param Event $event Event.
     */
    public function beforeFilter(Event $event)
    {
    }

    /**
     * Event called method on beforeRender.
     *
     * @param Event $event Event.
     */
    public function beforeRender(Event $event)
    {
    }

    /**
     * Event called method on shutdown.
     *
     * @param Event $event Event.
     */
    public function shutdown(Event $event)
    {
    }

    /**
     * Format route string to an array
     *
     * ```
     * // Default example
     * $this->addController('Custom Item', 'Admin/Custom::index');
     *
     * // With plugin
     * $this->addController('Custom Item', 'MyPlugin.Admin/Custom::index');
     *
     * // Without prefix (Admin)
     * $this->addController('Custom Item', 'Custom::index');
     *
     * // Without action (default `index`)
     * $this->addController('Custom Item', 'Admin/Custom');
     * ```
     *
     * @param string $route Route string
     * @return array
     */
    private function __formatRoute($route)
    {
        return [
            'plugin' => $this->__checkForPlugin($route),
            'prefix' => lcfirst($this->__checkForPrefix($route)),
            'controller' => $this->__checkForController($route),
            'action' => $this->__checkForAction($route) ?: 'index'
        ];
    }

    /**
     * Get the plugin from the route string
     *
     * @param string $route Route string
     * @return bool
     */
    private function __checkForPlugin($route)
    {
        if (strpos($route, '.') !== false) {
            $parts = explode('.', $route, 2);
            return $parts[0];
        }

        return false;
    }

    /**
     * Get the prefix from the route string
     *
     * @param string $route Route string
     * @return bool
     */
    private function __checkForPrefix($route)
    {
        if (strpos($route, '.') !== false) {
            $parts = explode('.', $route, 2);
            $route = $parts[1];
        }

        if (strpos($route, '/') !== false) {
            $parts = explode('/', $route, 2);
            return $parts[0];
        }

        return false;
    }

    /**
     * Get the controller from the route string
     *
     * @param string $route Route string
     * @return bool
     */
    private function __checkForController($route)
    {
        if (strpos($route, '.') !== false) {
            $parts = explode('.', $route, 2);
            $route = $parts[1];
        }

        if (strpos($route, '/') !== false) {
            $parts = explode('/', $route, 2);
            $route = $parts[1];
        }

        if (strpos($route, '::') !== false) {
            $parts = explode('::', $route, 2);
            return $parts[0];
        }

        return $route;
    }

    /**
     * Get the action from the route string
     *
     * @param string $route Route string
     * @return bool
     */
    private function __checkForAction($route)
    {
        if (strpos($route, '.') !== false) {
            $parts = explode('.', $route, 2);
            $route = $parts[1];
        }

        if (strpos($route, '/') !== false) {
            $parts = explode('/', $route, 2);
            $route = $parts[1];
        }

        if (strpos($route, '::') !== false) {
            $parts = explode('::', $route, 2);
            return $parts[1];
        }

        return false;
    }

}