Quick Start
===========

After the [installation](/installation.html), you are ready to login to your admin panel via `localhost/admin`. 
 
We will walk through the setup of CakeAdmin

## CakeAdmin Class

The `App\CakeAdmin` class is located in your own `src` folder and makes it easier to hook into CakeAdmin.

According to the [installation](/installation.html) section; you can generate this class using the command:

```
$ bin/cake cakeadmin init
```

[Read more about the CakeAdmin class here](/cakeadmin-class.html).

## PostTypes

PostTypes make managing data very easy. Creating a PostType will give you the basic crud actions to manage your models. For example:

Create the table `bookmarks` using the following query:

```
CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    description TEXT,
    url TEXT,
    created DATETIME,
    modified DATETIME
);
```

Now create your model via the command:

```
$ bin/cake bake model Bookmarks
```

Now CakeAdmin will join the process using the command:

```
$ bin/cake bake post_type Bookmarks
```

You can see a new file is created in `src/PostType/BookmarksPostType.php`. This is the PostType `Bookmarks`.

Now refresh your CakeAdmin dashboard and you will see a new menu item called `Bookmarks`. Click on it and you are able to see all bookmarks, create a new one,
modify existing bookmarks, and delete them.

Is this it? No! The PostType class we just created is able to manage your custom configurations. 

[Read more about PostTypes here](/posttypes.html).

## Custom Controllers

While CakeAdmin has some default controllers and PostTypes in it, we want to give you your freedom to extend CakeAdmin with your own functionality. This can be done
by creating your own custom controllers. To add custom controllers you must apply the following rules:

- Controller must contain the prefix `Admin` (path would become `/src/Controller/Admin`).
- Controller must depend on CakeAdmin's `Bakkerij/CakeAdmin/Controller/AppController` class.

> Note to developers: Probably a bake command could be implemented to create this like `cake bake cakeadmin_controller CustomController`

[Read more about controllers here](/custom-controllers.html).
