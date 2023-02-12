<?php

namespace App\Providers;

use App\Services\KubernetesService\Contracts\KubernetesService;
use App\Services\KubernetesService\RenokiCoKubernetesService;
use Illuminate\Support\ServiceProvider;

class KubernetesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(KubernetesService::class, RenokiCoKubernetesService::class);
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
