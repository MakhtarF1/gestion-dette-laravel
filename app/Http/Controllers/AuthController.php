<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Models\User;
use App\Models\Client;
use App\Models\Role;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreClientUserRequest;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');
    
        $user = User::where('login', $credentials['login'])->first();
    
        if (!$user) {
            return ApiResponseService::error("Utilisateur non trouvé: {$credentials['login']}", 404);
        }
    
        if (!Hash::check($credentials['password'], $user->password)) {
            return ApiResponseService::error("Mot de passe incorrect pour: {$credentials['login']}", 401);
        }
    
        $token = $user->createToken('Personal Access Token')->accessToken;
    
        return ApiResponseService::success([
            'message' => "Connexion réussie pour: {$credentials['login']}",
            'token' => $token
        ]);
    }
    
    public function logout(Request $request)
    {
        // Obtenir l'utilisateur actuellement authentifié
        $user = $request->user();

        // Révoquer le token
        $user->tokens()->delete();

        // Réponse en cas de succès
        return ApiResponseService::success(['message' => 'Successfully logged out']);
    }

    public function register(StoreUserRequest $userRequest, StoreClientUserRequest $clientRequest): JsonResponse
    {
        // Démarrer une transaction
        return DB::transaction(function () use ($userRequest, $clientRequest) {
            // Vérification si le client existe et n'a pas de compte utilisateur
            $client = Client::where('id', $clientRequest->clientid)
                ->whereNull('user_id')
                ->first();

            if (!$client) {
                return ApiResponseService::error('Le client doit exister et ne doit pas avoir de compte utilisateur.', 400);
            }

            // Création de l'utilisateur avec le nom et prénom du client
            $user = User::create([
                'name' => "{$client->prenom} {$client->nom}", // Utilisation du prénom et du nom
                'login' => $userRequest->login,
                'password' => Hash::make($userRequest->password),
                'role_id' => $this->getRoleId($userRequest->role), // Récupération de l'ID du rôle
            ]);

            // Association du client à l'utilisateur
            $client->user_id = $user->id;
            $client->save();

            return ApiResponseService::success([
                'client' => $client,
                'user' => $user,
            ], 201);
        });
    }

    private function getRoleId(string $role)
    {
        // Récupérer l'ID du rôle à partir de son libellé
        return Role::where('libelle', $role)->value('id');
    }
}
