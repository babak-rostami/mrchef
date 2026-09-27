<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Services\EmailService;
use App\Services\ImageService;
use App\Services\NotifierService;
use App\Services\SmsService;
use App\View\Composers\SchemaComposer;
use Illuminate\Support\Facades\View;
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
        // اسکیمای سراسری سایت (Organization/WebSite) رو به لایوت اصلی share می‌کنه
        View::composer('layouts.app', SchemaComposer::class);
    }
}
