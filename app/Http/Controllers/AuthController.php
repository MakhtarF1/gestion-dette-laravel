<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Services\AuthenticationServiceInterface;
use App\Services\ApiResponseService;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreClientUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthenticationServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');
        return $this->authService->authenticate($credentials);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout();
    }
    public function register(StoreUserRequest $userRequest): JsonResponse
    {
        // Debugging : Log des données de la requête
        logger()->info('Données de la requête:', $userRequest->all());
    
        // Créer l'utilisateur
        $user = User::create([
            'nom' => $userRequest->nom,
            'prenom' => $userRequest->prenom,
            'login' => $userRequest->login,
            'password' => Hash::make($userRequest->password),
            'photo' => $userRequest->photo, // Assurez-vous que c'est une chaîne
            'role_id' => $this->getRoleId($userRequest->role),
        ]);
    
        return response()->json([
            'message' => 'Utilisateur créé avec succès.',
            'user' => $user,
        ], 201);
    }
    
    

private function getRoleId(string $role)
{
    return Role::where('libelle', $role)->value('id');
}


}
