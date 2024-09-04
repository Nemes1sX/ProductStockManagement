<?php

namespace App\Providers;

use App\Interfaces\IProductService;
use App\Interfaces\IImportProductService;
use App\Interfaces\IImportProductStockService;
use App\Services\ImportProductService;
use App\Services\ProductService;
use App\Services\ImportProductStockService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(IImportProductService::class, ImportProductService::class);
        $this->app->bind(IImportProductStockService::class, ImportProductStockService::class);
    }
}
