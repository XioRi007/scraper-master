<?php

namespace App\Providers;

use App\Services\QueueService\Contracts\QueueService;
use App\Services\QueueService\RedisQueueService;
use Illuminate\Support\ServiceProvider;

class QueueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueueService::class, RedisQueueService::class);
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
