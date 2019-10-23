<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use App\Services\UploadService;
use function foo\func;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Category
        view()->composer('frontend.layouts.menu', function ($view) {
            $categories = Category::getMenuCategory();

            $view->with(['categories' => $categories]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\UploadService', function ($app) {
            return new UploadService();
        });
    }
}
