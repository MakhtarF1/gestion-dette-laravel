<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SuccessResponseMiddleware;

Route::prefix('api/v1')->group(function () {

    // Route de connexion (pas protégée)
    Route::post('login', [AuthController::class, 'login'])->name('user.login');

    // Routes protégées avec Passport et le middleware SuccessResponseMiddleware
    Route::middleware(['auth:api', "success.response"::class])->group(function () {

        // Route de déconnexion
        Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::post('register', [AuthController::class, 'register'])->name('user.register');

        // Routes pour les utilisateurs
        Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Routes pour les clients
        Route::post('clients/optional', [ClientController::class, 'storeOptional'])->name('clients.optional');
        Route::post('clients/{id}/user', [ClientController::class, 'showWithUser'])->name('clients.showWithUser');
        Route::post('clients/{id}/dettes', [ClientController::class, 'getDetteByClient'])->name('clients.getDetteByClient');
        Route::post('clients/telephone', [ClientController::class, 'showByTelephone'])->name('clients.showByTelephone');
        Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('clients/{id}', [ClientController::class, 'show'])->name('clients.show');
        Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
        Route::delete('clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');

        // Routes pour les articles
        Route::put('articles', [ArticleController::class, 'FullUpdate'])->name('articles.FullUpdate');
        Route::get('articles/{libelle}', [ArticleController::class, 'findByLibelle'])->name('articles.getByLibelle');
        Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
        Route::patch('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });
});
