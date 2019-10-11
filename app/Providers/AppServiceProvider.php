<?php

namespace App\Providers;

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
        //
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
