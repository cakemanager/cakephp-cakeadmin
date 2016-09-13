# Bakkerij/CakeAdmin plugin for CakePHP

## Install CakePHP

Note: This is only required if you do not already have a project started.

```
$ composer self-update && composer create-project --prefer-dist cakephp/app {your new project name}
```

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
$ composer require bakkerij/cakeadmin:dev-rewrite
```

## Update Database Info

Navigate to the new project's config/app.php and update your Datasources username, password, and database.

## Load CakeAdmin Tables

```
$ bin/cake migrations migrate -p Bakkerij/CakeAdmin
```

