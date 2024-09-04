<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Services\AuthenticationServiceInterface;
use App\Services\AuthenticationPassport;
use App\Services\AuthenticationSanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(AuthenticationServiceInterface::class, function ($app) {
           $instance=new AuthenticationPassport(); 
           return $instance;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {  
        $this->registerPolicies();      
    }
}
