<?php

namespace App\Providers;

use App\Infrastructure\Persistence\Eloquent\EloquentProductRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentUserRepository;
use App\Infrastructure\Persistence\ProductRepository;
use App\Infrastructure\Persistence\UserRepository;
use App\UseCases\ListProducts\ListProducts;
use App\UseCases\Login\Login;
use App\UseCases\SyncProducts\FakeStoreSyncProducts;
use App\UseCases\SyncProducts\SyncProductsInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);

        $this->app->bind(Login::class, Login::class);
        $this->app->bind(ListProducts::class, ListProducts::class);
        $this->app->bind(SyncProductsInterface::class, FakeStoreSyncProducts::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
