<?php

namespace App\Providers;

use App\Interfaces\BrandInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CommentInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\PaymentMethodInterface;
use App\Interfaces\PostInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductPropertyInterface;
use App\Interfaces\ShippingInterface;
use App\Interfaces\UserInterface;
use App\Repositories\BrandRepository;
use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProductPropertyRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShippingRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryInterface::class,CategoryRepository::class);
        $this->app->bind(ProductInterface::class,ProductRepository::class);
        $this->app->bind(PostInterface::class,PostRepository::class);
        $this->app->bind(CartInterface::class,CartRepository::class);
        $this->app->bind(OrderInterface::class,OrderRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(ProductPropertyInterface::class,ProductPropertyRepository::class);
        $this->app->bind(BrandInterface::class,BrandRepository::class);
        $this->app->bind(ShippingInterface::class,ShippingRepository::class);
        $this->app->bind(CommentInterface::class,CommentRepository::class);
        $this->app->bind(PaymentMethodInterface::class,PaymentMethodRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
