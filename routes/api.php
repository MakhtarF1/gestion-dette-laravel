<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwaggerController;


Route::prefix('api/v1')->group(function () {

    // Route de connexion (pas protégée)
    Route::post('login', [AuthController::class, 'login'])->name('user.login');

    // Routes protégées avec Passport
    Route::middleware('auth:api')->group(function () {

        // Route de déconnexion (pas protégée)
        Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::post('register', [AuthController::class, 'register']);
        // Route::get('/documentation', [SwaggerController::class, 'index']);

    
        // Routes pour les utilisateurs
       
        Route::get('users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users', [UserController::class, 'index']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('users/{id}', [UserController::class, 'destroy']);

        // Routes pour les clients

        Route::post('clients/{id}/user', [ClientController::class, 'showWithUser']);
        Route::post('clients/{id}/dettes', [ClientController::class, 'getDetteByClient']);
        Route::post('clients/telephone', [ClientController::class, 'showByTelephone']);
        Route::get('clients', [ClientController::class, 'index']);
        Route::get('clients/{id}', [ClientController::class, 'show']);
        Route::post('clients', [ClientController::class, 'store']);
        Route::delete('clients/{id}', [ClientController::class, 'destroy']);

        // Routes pour les articles
        Route::put('articles', [ArticleController::class, 'FullUpdate'])->name('articles.FullUpdate');
        Route::post('articles/libelle', [ArticleController::class, 'getByLibelle']);
        Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
        Route::patch('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');//error
        Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });
});
