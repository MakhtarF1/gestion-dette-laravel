<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Client;
use App\Models\Dette;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\ClientPolicy;
use App\Policies\DettePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Services\AuthenticationServiceInterface;
use App\Services\AuthenticationPassport;
use App\Services\AuthenticationSanctum;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
         Article::class => ArticlePolicy::class,
         Client::class => ClientPolicy::class,
         Dette::class => DettePolicy::class,
         User::class => UserPolicy::class,

    ];
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
