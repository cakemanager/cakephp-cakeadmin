CakeAdmin Class
===============

The CakeAdmin class is a class located in `/src/CakeAdmin.php` to make hooking into CakeAdmin much easier. This class will only be executed when a page of CakeAdmin is
requested, so your own controller classes won't be hurt.

After generating the class with `$ bin/cake cakeadmin init`, the class will look like:

```
<?php

namespace App;

use Bakkerij\CakeAdmin\BaseCakeAdmin;

class CakeAdmin extends BaseCakeAdmin {

    public function initialize()
    {
        
    }

}
```

## Methods

In the `initialize`-method you can use the following methods:

### `registerPostType`

Registering PostTypes can be done using:

```
// App
$this->registerPostType('Bookmarks');

// Plugin
$this->registerPostType('MyPlugin.Bookmarks');

```

### `addController`

Adding your custom controller to CakeAdmin can be done using the `addController` method. You can use multiple formats to parse the route:

Default example

```
$this->addController('Custom Item', 'Admin/Custom::index');
```

With plugin
 
```
$this->addController('Custom Item', 'MyPlugin.Admin/Custom::index');
```
 
Without prefix (Admin)
```
$this->addController('Custom Item', 'Custom::index');
```

Without action (default `index`)
 
```
$this->addController('Custom Item', 'Admin/Custom');
```

As array

```
$this->addController('Custom Item', [
    'plugin' => false,
    'prefix' => 'admin',
    'controller' => 'Custom',
    'action' => 'index'
]);
```

### `addMenuItem`

Adding a custom menu item can be done using:

```
$this->addMenuItem('cakeadmin_main', 'Dashboard', ['uri' => [
    'plugin' => 'Bakkerij/CakeAdmin',
    'prefix' => 'admin',
    'controller' => 'Dashboard',
    'action' => 'index'
]]);
```

> Note to developers: Not implemented yet ;)

## Events

The following events are listened by the CakeAdmin class. By creating those methods you can hook into the events.

### `CakeAdmin.Controller.startup`

```
public function startup(Event $event)
{
    
}
```

### `CakeAdmin.Controller.beforeRedirect`

```
public function beforeRedirect(Event $event)
{

}
```

### `CakeAdmin.Controller.beforeFilter`

```
public function beforeFilter(Event $event)
{

}
```

### `CakeAdmin.Controller.beforeRender`

```
public function beforeRender(Event $event)
{

}
```

### `CakeAdmin.Controller.shutdown`

```
public function shutdown(Event $event)
{

}
```

### Add events

To add your own implemented events use the following code:

```
public function implementedEvents()
    {
        $events = parent::implementedEvents();

        $events['your.event'] = 'yourEvent';

        return $events;
    }
```