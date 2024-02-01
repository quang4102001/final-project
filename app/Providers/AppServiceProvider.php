<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Providers\Composers\CategoryComposer;
use App\Providers\Composers\ColorComposer;
use App\Providers\Composers\SizeComposer;
use Illuminate\Pagination\Paginator;
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
        //
        Paginator::useBootstrapFive();
        // View::share('categories', Category::all());
        // View::share('colors', Color::all());
        // View::share('sizes', Size::all());
        View::composer(['home.index', 'admin.products.*'], CategoryComposer::class);
        View::composer(['home.index', 'admin.products.*'], SizeComposer::class);
        View::composer(['home.index', 'admin.products.*'], ColorComposer::class);
    }
}
