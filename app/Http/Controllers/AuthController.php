<?php

namespace App\Http\Controllers;

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

    public function register(StoreUserRequest $userRequest, StoreClientUserRequest $clientRequest): JsonResponse
    {
        return DB::transaction(function () use ($userRequest, $clientRequest) {
            $client = Client::where('id', $clientRequest->clientid)
                ->whereNull('user_id')
                ->first();

            if (!$client) {
                return ApiResponseService::error('Le client doit exister et ne doit pas avoir de compte utilisateur.', 400);
            }

            $user = User::create([
                'name' => "{$client->prenom} {$client->nom}",
                'login' => $userRequest->login,
                'photo' => $userRequest->photo,
                'password' => Hash::make($userRequest->password),
                'role_id' => $this->getRoleId($userRequest->role),
            ]);

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
        return Role::where('libelle', $role)->value('id');
    }
}
