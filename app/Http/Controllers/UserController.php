<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest; // Utilisez la classe de validation du formulaire de création d'utilisateur
use App\Services\ApiResponseService;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role'); // Inclure le rôle associé

        // Filtrer par rôle si spécifié
        if ($request->has('role')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('libelle', $request->query('role'));
            });
        }

        // Filtrer par statut actif si spécifié
        if ($request->has('active')) {
            $etat = $request->query('active') === 'oui' ? 'actif' : 'inactif';
            $query->where('etat', $etat);
        }

        // Récupérer la liste des utilisateurs triés par ordre alphabétique
        $users = $query->orderBy('name')->paginate(10);

        return ApiResponseService::success(UserResource::collection($users));
    }




    public function store(StoreUserRequest $request)
    {
        // Vérifier si l'utilisateur authentifié est un admin
        $authUser = $request->user();

        if ($authUser->role && trim($authUser->role->libelle) !== 'admin') {
            return ApiResponseService::error('Vous n\'êtes pas autorisé à créer un compte utilisateur.', 403);
        }

        // Valider les données
        $data = $request->validated();

        // Récupérer l'ID du rôle à partir du libellé
        $role = Role::where('libelle', $data['role'])->first();

        if (!$role) {
            return ApiResponseService::error('Le rôle spécifié n\'existe pas.', 400);
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $data['name'],
            'login' => $data['login'],
            'password' => bcrypt($data['password']),
            'etat' => 'actif',
            'role_id' => $role->id, // Utiliser l'ID du rôle récupéré
        ]);

        return ApiResponseService::success(new UserResource($user), 201);
    }



    public function show($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return ApiResponseService::error('Utilisateur avec l\'ID spécifié n\'existe pas.', 404);
        }
        return ApiResponseService::success(new UserResource($user));
    }


    public function update(StoreUserRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::findOrFail($id);

        $updateData = [
            'name' => $data['nom'] . ' ' . $data['prenom'],
            'login' => $data['login'],
        ];

        if (isset($data['password'])) {
            $updateData['password'] = bcrypt($data['password']);
        }

        $user->update($updateData);

        return ApiResponseService::success(new UserResource($user));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
       
        return ApiResponseService::successWithMessage('Utilisateur supprimé avec succès.', null, 204);
    }
    
}
