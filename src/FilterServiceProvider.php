<?php

namespace Putheng\Filter;

use Illuminate\Support\ServiceProvider;
use Putheng\Filter\Commands\{
    FiltersMakeCommand,
    FilterChildCommand
};

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FiltersMakeCommand::class,
                FilterChildCommand::class
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
