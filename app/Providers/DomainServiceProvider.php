<?php

namespace App\Providers;

use Domain\Cart\Providers\CartServiceProvider;
use Domain\Catalog\Providers\CatalogServiceProvider;
use Domain\Order\Providers\OrderServiceProvider;
use Domain\Payment\Providers\PaymentServiceProvider;
use Domain\Product\Providers\ProductServiceProvider;
use Illuminate\Support\ServiceProvider;
use Domain\User\Providers\AuthServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(CartServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(CatalogServiceProvider::class);
        $this->app->register(ProductServiceProvider::class);
        $this->app->register(OrderServiceProvider::class);
        $this->app->register(PaymentServiceProvider::class);
    }
}
