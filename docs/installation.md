Installation
============

## Requirements

You need PHP >= 5.5.9 to use CakeAdmin, and CakePHP 3.2 or higher.

## Composer

CakeAdmin is available on [Packagist](https://packagist.org/) and can be installed using [Composer](https://getcomposer.org/):

```
$ composer require bakkerij/cakeadmin
```

> Note: while this plugin is under development, just clone the repository into `plugins/Bakkerij/CakeAdmin`

## Loading the plugin

Run the following command:

```
$ bin/cake plugin load -b -r Bakkerij/CakeAdmin
```

Or add the following to your `/config/bootstrap.php`:

```
Plugin::load('Bakkerij/CakeAdmin', ['bootstrap' => true, 'routes' => true]);
```

## Initializing CakeAdmin

To make hooks to CakeAdmin easier, CakeAdmin makes use of an `App/CakeAdmin` class. This class can be generated running the command:

```
$ bin/cake cakeadmin init
```

## Creating an user

To create your first administrator you can run the command:

```
$ bin/cake cakeadmin admin
```

This command will ask for your e-mail and name, and will set the default password `cakeadmin` (you can change this later on). 
