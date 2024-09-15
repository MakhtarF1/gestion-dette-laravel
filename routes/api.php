<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DetteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SuccessResponseMiddleware;
use App\Services\ClientServiceInterface;
use App\Services\ServiceArchiveInterface;

Route::prefix('api/v1')->group(function () {

    // Route de connexion (pas protégée)
    Route::post('login', [AuthController::class, 'login'])->name('user.login');

    // Route::get('/archives', [ArchiveController::class, 'index']);


    // Routes protégées avec Passport et le middleware SuccessResponseMiddleware
    Route::middleware(['auth:api', "success.response"::class])->group(function () {


        //route demande dette
        Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');

        // Route pour obtenir toutes les demandes ou celles du client
        Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
    
        // Route pour obtenir une demande spécifique par ID
        Route::get('/demandes/{id}', [DemandeController::class, 'show'])->name('demandes.show');
    
        // Route pour annuler une demande par ID (accessible uniquement pour les boutiquiers)
        Route::put('/demandes/{id}/refuser', [DemandeController::class, 'reject'])->name('demandes.reject');
    
        Route::get('/notifications', [NotificationController::class, 'index']);

        // Route de déconnexion
        Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::post('register', [AuthController::class, 'register'])->name('user.register');

        Route::post('/clients/{clientId}/paiements', [PaiementController::class, 'store']);


        // Routes pour les utilisateurs
        Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Routes pour les dettes
        Route::post('dettes', [DetteController::class, 'createDette'])->name('dettes.createDette');
        Route::get('dettes', [DetteController::class, 'index'])->name('dettes.index');

        // Routes pour les clients
        Route::post('clients/{id}/user', [ClientController::class, 'showWithUser'])->name('clients.showWithUser');
        Route::post('clients/{id}/dettes', [ClientController::class, 'getDetteByClient'])->name('clients.getDetteByClient');
        Route::post('clients/telephone', [ClientController::class, 'showByTelephone'])->name('clients.showByTelephone');
        Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('clients/{id}', [ClientController::class, 'show'])->name('clients.show');
        Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
        Route::delete('clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');

        // Routes pour les articles
        Route::get('articles/{libelle}', [ArticleController::class, 'findByLibelle'])->name('articles.getByLibelle');
        Route::get('articles/{libelle}', [ArticleController::class, 'findById'])->name('articles.getById');
        Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::post('articles/stock', [ArticleController::class, 'updateMultipleStocks']);
        Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
        Route::patch('articles/{article}', [ArticleController::class, 'updateStock'])->name('articles.update');
        Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });
});
