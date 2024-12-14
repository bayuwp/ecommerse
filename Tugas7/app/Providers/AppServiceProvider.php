<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Kategori;
use App\Models\Produk;

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
        View::share('kategoris', Kategori::all());
        View::share('bestSellingProducts', Produk::orderBy('sold', 'desc')->take(5)->get());
        View::share('recommendedProducts', Produk::inRandomOrder()->take(5)->get());
        View::share('cartCount', auth()->check() ? Cart::where('user_id', Auth::id())->count() : 0);
    }
}
