<?php

namespace App\Providers;

use App\Services\Category\CategoryService;
use App\Services\Category\CategoryServiceImplement;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceImplement;
use App\Services\Supplier\SupplierService;
use App\Services\Supplier\SupplierServiceImplement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SupplierService::class, SupplierServiceImplement::class);
        $this->app->bind(CategoryService::class, CategoryServiceImplement::class);
        $this->app->bind(ProductService::class, ProductServiceImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
