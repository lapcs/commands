<?php

namespace Lapcs\Commands;

use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Lapcs\Commands\Console\Commands\MakeModule',
        'Lapcs\Commands\Console\Commands\ModuleGenerate',
        'Lapcs\Commands\Console\Commands\MakeController',
        'Lapcs\Commands\Console\Commands\MakeRequest',
        'Lapcs\Commands\Console\Commands\MakeHelper',
        'Lapcs\Commands\Console\Commands\MakeComponent',
        'Lapcs\Commands\Console\Commands\Ans',
    ];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/lapcs-command.php' => config_path('lapcs-command.php')
        ], 'config');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/lapcs-command.php', 'lapcs-command'
        );
        $this->commands($this->commands);
        $this->app->bind('lapcs-commands', function() {
            return new Command;
        });
    }
}
