<?php

namespace App\Providers;

use App\Repositories\ActivityRepo;
use App\Repositories\Contracts\ActivityRepoInterface;
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
        $this->app->bind(ActivityRepoInterface::class, ActivityRepo::class);
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
