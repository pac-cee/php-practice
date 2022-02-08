<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
        // Register middleware aliases
        Route::aliasMiddleware('auth', \App\Http\Middleware\Authenticate::class);
        Route::aliasMiddleware('admin', \App\Http\Middleware\AdminOnly::class);
    }
}
