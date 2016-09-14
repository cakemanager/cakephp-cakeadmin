PostTypes
=========

PostTypes are a great way to manage your table data per model.

## Basic Usage

To get started, create a PostType class. These classes live in `src/PostType`. The most basic PostType class would look like:

```
// src/PostType/BookmarksPostType.php
namespace App\PostType;

use Bakkerij\CakeAdmin\PostType\PostType;

class BookmarksPostType extends PostType
{
}
```

Note that we did not tell the PostType which model to use for our PostType. By convention PostType objects will use a model that matches the upper cased version of the 
class name. In the above example the `Bookmarks` model will be used. If our PostType class was named `BlogPosts` your model should be named `BlogPosts` as well.
You can specify the model to using the `model()` method:

```
// src/PostType/BookmarksPostType.php
namespace App\PostType;

use Bakkerij\CakeAdmin\PostType\PostType;

class BookmarksPostType extends PostType
{

    public function initialize() {
        
        $this->model('Bookmarks');
        
    }

}
```

The same rule is applied to the name of the PostType and its slug (used in routes). You can define them using the `name()` and `slug()` method:

```
// src/PostType/BookmarksPostType.php
namespace App\PostType;

use Bakkerij\CakeAdmin\PostType\PostType;

class BookmarksPostType extends PostType
{

    public function initialize() {
        
        $this->name('Bookmarks'); // also `alias()` could be used
        $this->slug('bookmarks');
        
    }

}
```

## Appearance in Menu

By default the PostTypes appears in CakeAdmin's main menu (on the left). To disable this, use the `menu()` method:

```
    public function initialize() {
        
        $this->menu(false);
        
    }
```

## Adding a Description

To add a description to your PostType, use the `description()` method:

```
    public function initialize() {
        
        $this->description('Manages all bookmarks of the application.');
        
    }
```

## Actions

By default, the following actions are available:

- index
- add
- view
- edit
- delete

To disable or enable any action, you can use the `action()` method:

```
    public function initialize() {
        
        // enable
        $this->action('index' => true);
        
        // disable
        $this->action('add' => false);
                
    }
```

To get the current state of an action, use the same `action()` method without any argument:

```
$state = $this->action('add');
```

To get the state of all actions, use `actions()`:

```
$actions = $this->actions();
```

> Note; while Crud is used, at this time it isn't possible yet to customize the `Action` to use.

## Table Columns

By default the table (on the index page of the PostType) contains the following columns:

- primary key (usually `id`)
- display field (given in the Model)
- `created` and `modified` when the `Timestamp` behavior is loaded

You can choose your own columns using the `tableColumns()` method:

```
    public function initialize() {
        
        $this->tableColumns([
            'id',
            'title',
            'url',
            'created',
            'modified'
        ]);
                
    }
```

You can use different getters using the `get` key as option:

```
$this->tableColumns([
    'url' => [
        'get' => 'customUrl'
    ],
]);
```

This can be useful when you are using [virtual fields](http://book.cakephp.org/3.0/en/orm/entities.html#creating-virtual-fields).

## Form Fields

By default the form (on the add and edit page of the PostType) contains all columns from the table excluding `created` and `modified` when the `Timestamp` behavior
is loaded. 

You can choose your own fields using the `formFields()` method:

```
    public function initialize() {
        
        $this->formFields([
            'id',
            'title',
            'description',
            'created',
            'modified'
        ]);
                
    }
```

By default, all fields are presented in both forms: add and edit. To enable fields only on add, or only on edit, use the `on` key as option:

```
$this->formFields([
    'description' => [
        'on' => 'add'
    ],
]);
```

In this case, the description field will only be displayed on the add page, and not on the edit page.

## Filters

> Note to developers: Not implemented yet.

## Table Instance

By default a Table instance is created from the `model()` value, but in case you want to modify the table instance you can modify the Table instance using:

```
    public function initialize() {
        
        // get table instance
        $table = $this->table();
        
        // modify $table
        
        // set table instance
        $this->table($table);
    }
```

From now on, the modified table instance will be used.

