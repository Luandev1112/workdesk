<?php

namespace App\Providers;

use App\Repositories\Badge\BadgeInterface;
use App\Repositories\Badge\BadgeRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\AbstractInterface;
use App\Repositories\AbstractRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AbstractInterface::class, AbstractRepository::class);
        $this->app->bind(BadgeInterface::class, BadgeRepository::class);
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
