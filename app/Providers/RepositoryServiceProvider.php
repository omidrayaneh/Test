<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\TagRepositoryInterface',
            'App\Repositories\Eloquent\TagRepository'
        );
        $this->app->bind(
            'App\Repositories\ProductRepositoryInterface',
            'App\Repositories\Eloquent\ProductRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
