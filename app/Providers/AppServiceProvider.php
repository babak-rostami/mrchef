<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Services\EmailService;
use App\Services\ImageService;
use App\Services\NotifierService;
use App\Services\SmsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('image-service', function () {
            return new ImageService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
