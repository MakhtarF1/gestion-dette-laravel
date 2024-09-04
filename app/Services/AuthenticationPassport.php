<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthenticationPassport implements AuthenticationServiceInterface
{
    public function authenticate(array $credentials): JsonResponse
    {
        $user = User::where('login', $credentials['login'])->first();

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Mot de passe incorrect'], 401);
        }

        $tokenResult = $user->createToken('Personal Access Token', ['*'], [
            'id' => $user->id,
            'role' => $user->role->libelle,
            'photo' => $user->photo,
            'name' => $user->name,
            'login' => $user->login,
            'etat' => $user->etat,
            'role_id' => $user->role_id,
        ]);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'expires_in' => $tokenResult->token->expires_at->diffInSeconds(now()),
        ], 200);
    }


    public function logout()
    {
        // Implémentez la méthode de déconnexion ici
    }
}
