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
composer require lapcs/commands:1.3.x-dev
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
	// Create folder Modules default to app\Modules
	php artisan ans:setup 

	// Add ModuleServiceProvider to config
	// Laravel : config\app.php
	'providers' => [
		...
		App\Modules\ModuleServiceProvider::class,
	 ]

	// Lumen : bootstrap\app.php
	Add : $app->register(App\Modules\ModuleServiceProvider::class);

	// Make module : Ex Master
	php artisan ans:module master

	// Make ExController in module Master 
	php artisan ans:controller master Ex OR php artisan ans:controller master ExController

	// Make Request  
	php artisan ans:request master MasterRequest

	... to help command
	php artisan ans:help

```

## Command helper
``` Create HMVC module
	php artisan ans:help 
```
## Publish config
``` 
	php artisan vendor:publish --tag=config
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

The MIT License (MIT). Please see [License File](LICENSE) for more information.
