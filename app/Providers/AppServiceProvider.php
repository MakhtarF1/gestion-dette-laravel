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
use App\Repositories\DetteRepositoryImpl;
use App\Repositories\DetteRepositoryInterface;
use App\Repositories\PaiementRepositoryImpl;
use App\Repositories\PaiementRepositoryInterface;
use App\Services\ArchiveDetteServiceInterface;
use App\Services\DetteServiceImpl;
use App\Services\DetteServiceInterface;
use App\Services\FirebaseArchiveDetteService;
use App\Services\FireBaseService;
use App\Services\InfobipService;
use App\Services\MongoArchiveDetteService;
use App\Services\MongoDBService;
use App\Services\PaiementServiceImpl;
use App\Services\PaiementServiceInterface;
use App\Services\ServiceArchiveInterface ;
use App\Services\SmsServiceInterface;
use App\Services\TwilioService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register()
    {
        // $this->app->bind(ArchiveDetteServiceInterface::class, MongoArchiveDetteService::class);
        // $this->app->bind(ArchiveDetteServiceInterface::class, FirebaseArchiveDetteService::class);

        $this->app->bind(ArchiveDetteServiceInterface::class, function ($app) {
            return env('ARCHIVE_SERVICE') === 'mongo'
                ? new MongoArchiveDetteService()
                : new FirebaseArchiveDetteService();
        });

        // Switch between infobip or twilio based on .env
        $this->app->singleton(SmsServiceInterface::class, function ($app) {
            return env('SMS_SERVICE') === 'infobip'
                ? new InfobipService()
                : new TwilioService();
        });
        
        $this->app->singleton(DetteRepositoryInterface::class, DetteRepositoryImpl::class);
        $this->app->singleton(DetteServiceInterface::class, DetteServiceImpl::class);
        $this->app->singleton(ClientRepositoryInterface::class, ClientRepositoryImpl::class);
        $this->app->singleton(ClientServiceInterface::class, ClientServiceImpl::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepositoryImpl::class);
        $this->app->singleton(UserServiceInterface::class, UserServiceImpl::class);
        $this->app->bind(ArticleServiceInterface::class, ArticleServiceImpl::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepositoryImpl::class);
        $this->app->bind(UploadServiceInterface::class, UploadService::class);
        $this->app->bind(QrServiceInterface::class, QrServiceImpl::class);
        $this->app->bind(PaiementRepositoryInterface::class, PaiementRepositoryImpl::class);
        $this->app->bind(PaiementServiceInterface::class, PaiementServiceImpl::class);
        // $this->app->bind(ServiceArchiveInterface::class, MongoDBService::class);
        // $this->app->bind(ServiceArchiveInterface::class, FireBaseService::class);
        // $this->app->singleton(ServiceArchiveInterface::class, function ($app) {
        //     if(env("DATABASE_ARCHIVE_USING") == "firebase"){
        //         return new FirebaseService();
        //     }
        //     return new MongoDBService();
        
        // });
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
