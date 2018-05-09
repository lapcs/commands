# Laravel-Modules
# lumen-Modules

| **Laravel/lumen**  |  **laravel-modules/lumen-modules** |
|---|---|
| 5.6  | ^dev  |

`lapcs/commands` is a Laravel or lumen package which created to manage your large  Laravel or lumen app using modules. Module is like a  Laravel or lumen package, it has some views, controllers,helper,component (vuejs) or models. This package is supported and tested in Laravel 5.* or lumen 5.*

With one big added bonus that the original package didn't have: **tests**.


## Install

To install through Composer, by run the following command:

``` bash
composer require lapcs/commands
```

## Lumen config
``` bash
 //bootstrap\app.php
 Add : $app->register(Lapcs\Commands\CommandServiceProvider::class);
```

## Laravel config
``` bash
  //config\app.php
 'providers' => [
	...
	Lapcs\Commands\CommandServiceProvider::class,
 ]
```

## Setup HMVC
``` Create HMVC module
	// create folder default to app\Modules
	php artisan ans:setup 
```

## Command helper
``` Create HMVC module
	php artisan ans:help 
```

The package will automatically register a service provider and alias.

Optionally, publish the package's configuration file by running:

### Autoloading



**Tip: don't forget to run `composer dump-autoload` afterwards.**

## Documentation

You'll find installation instructions and full documentation on : comming son....
 
 
## Credits ....


## About lapcs command

lapcs command is a freelance web developer specialising on the Laravel/lumen framework.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
