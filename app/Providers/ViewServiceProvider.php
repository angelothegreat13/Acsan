<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('web/layouts/_header', function ($view) {
            $view->with('totalCartQty',  \App\Models\Cart::totalQty());
        });

        View::composer(['web/layouts/_navbar','web/layouts/_footer'], function ($view) {
            $view->with('categories',  \App\Models\Category::all());
        });
    }
}