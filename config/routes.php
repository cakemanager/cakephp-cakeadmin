<?php
use Cake\Routing\Router;

Router::plugin('CakeAdmin', ['path' => '/admin'], function ($routes) {

    $routes->connect(
        '/posttypes/:type/:action/*', ['controller' => 'PostTypes'], ['pass' => ['type']]
    );

    $routes->connect(
        '/', ['controller' => 'Users', 'action' => 'login']
    );

    $routes->fallbacks('InflectedRoute');
});
