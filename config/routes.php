<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('admin', function ($routes) {

    $routes->fallbacks('InflectedRoute');

});

Router::plugin('Bakkerij/CakeAdmin', ['path' => '/', '_namePrefix' => 'cakeadmin:'], function (RouteBuilder $routes) {

    $routes->prefix('admin', function ($routes) {

        // User routes
        $routes->connect(
            '/login',
            [
                'controller' => 'Users',
                'action' => 'login',
            ],
            [
                '_name' => 'login'
            ]
        );
        $routes->connect(
            '/logout',
            [
                'controller' => 'Users',
                'action' => 'logout',
            ],
            [
                '_name' => 'logout'
            ]
        );

        // Default admin route
        $routes->connect(
            '/',
            ['controller' => 'Dashboard']
        );

        // PostType routes
        $routes->connect(
            '/posttype/:type/',
            ['controller' => 'PostTypes', 'action' => 'index'],
            ['_name' => 'posttype:index', 'pass' => ['type']]
        );
        $routes->connect(
            '/posttype/:type/index',
            ['controller' => 'PostTypes', 'action' => 'index'],
            ['pass' => ['type']]
        );
        $routes->connect(
            '/posttype/:type/add',
            ['controller' => 'PostTypes', 'action' => 'add'],
            ['_name' => 'posttype:add', 'pass' => ['type']]
        );
        $routes->connect(
            '/posttype/:type/edit/:id',
            ['controller' => 'PostTypes', 'action' => 'edit'],
            ['_name' => 'posttype:edit', 'pass' => ['id', 'type']]
        );
        $routes->connect(
            '/posttype/:type/view/:id',
            ['controller' => 'PostTypes', 'action' => 'view'],
            ['_name' => 'posttype:view', 'pass' => ['id', 'type']]
        );
        $routes->connect(
            '/posttype/:type/delete/:id',
            ['controller' => 'PostTypes', 'action' => 'delete'],
            ['_name' => 'posttype:delete', 'pass' => ['id', 'type']]
        );

        $routes->fallbacks('DashedRoute');

    });

});
