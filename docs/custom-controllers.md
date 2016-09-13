Custom Controllers
==================

While CakeAdmin has some default controllers and PostTypes in it, we want to give you your freedom to extend CakeAdmin with your own functionality. This can be done
by creating your own custom controllers. To add custom controllers you must apply the following rules:

- Controller must contain the prefix `Admin` (path would become `/src/Controller/Admin`).
- Controller must depend on CakeAdmin's `Bakkerij/CakeAdmin/Controller/AppController` class.

> Note to developers: Probably a bake command could be implemented to create this like `cake bake cakeadmin_controller CustomController`

Example:

```
<?php
namespace App\Controller\Admin;

class CustomController extends \Bakkerij\CakeAdmin\Controller\AppController
{

    public function index()
    {
    }


}
```

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