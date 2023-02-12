<?php

namespace App\Providers;

use App\Repositories\QueueItemRepository;
use App\Repositories\ScraperJobRepository;
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
        //$this->app->bind(ScraperJobRepository::class, QueueItemRepository::class);
        $this->app->bind(ScraperJobRepository::class, function ($app) {
            return new ScraperJobRepository();
        });
        $this->app->bind(QueueItemRepository::class, function ($app) {
            return new QueueItemRepository();
        });
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
