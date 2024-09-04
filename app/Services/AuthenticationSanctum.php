<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthenticationSanctum implements AuthenticationServiceInterface
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

        // Création du token avec Sanctum
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ], 200);
    }

    public function logout()
    {
      
    }
}
