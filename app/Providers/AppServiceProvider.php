<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\ClientRepositoryImpl;
use App\Services\ClientServiceInterface;
use App\Services\ClientServiceImpl;
use App\Services\ArticleServiceImpl;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryImpl;
use App\Repositories\ArticleRepositoryInterface;
use App\Services\ArticleServiceInterface;
use App\Services\UploadServiceInterface;
use App\Services\UploadService;
use App\Repositories\UserRepositoryImpl;
use App\Services\UserServiceImpl;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserServiceInterface;
use App\Services\QrServiceInterface;
use App\Services\QrServiceImpl;
use App\Observers\UserObserver;
use App\Models\User;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register()
    {
        $this->app->singleton(ClientRepositoryInterface::class, ClientRepositoryImpl::class);
        $this->app->singleton(ClientServiceInterface::class, ClientServiceImpl::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepositoryImpl::class);
        $this->app->singleton(UserServiceInterface::class, UserServiceImpl::class);
        $this->app->bind(ArticleServiceInterface::class, ArticleServiceImpl::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepositoryImpl::class);
        $this->app->bind(UploadServiceInterface::class, UploadService::class);
        $this->app->bind(QrServiceInterface::class, QrServiceImpl::class);
    }



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);

        

        // Charger les routes pour les utilisateurs et les clients (API)
        Route::middleware('api')
            ->group(base_path('routes/api.php'));
    }
}
