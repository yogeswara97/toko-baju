<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('navbarCategories', Category::all());

            $cartCount = auth()->check()
                ? Cart::where('user_id', auth()->id())->count()
                : session('cart_count', 0);

            $view->with('cartCount', $cartCount);
        });
    }
}
