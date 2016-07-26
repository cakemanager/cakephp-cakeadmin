<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;

// Load Crud plugin
if(!Plugin::loaded('Crud')) {
    Plugin::load('Crud');
}

// Load Knp plugin
if(!Plugin::loaded('Gourmet/KnpMenu')) {
    Plugin::load('Gourmet/KnpMenu');
}

// Sessions timeout
Configure::write('Session.timeout', 4320);

// Configure login fields
Configure::write('CA.fields', [
    'username' => 'email',
    'password' => 'password'
]);

// Registered PostTypes
//Configure::write('CA.postTypes', [
//    'bookmarks' => 'Bookmarks'
//]);

// Custom menu items
Configure::write('CA.menu', [
    'main' => []
]);