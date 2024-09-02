<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;
use App\Models\Dette;
use App\Http\Resources\ClientResource;
use App\Services\ApiResponseService;
use App\Http\Resources\UserResource;
use App\Services\ValidateClientData; // Utilisez la classe de validation
use App\Http\Requests\StoreClientRequest; // Utilisez la classe de validation
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;




class ClientController extends Controller
{
    public function index(Request $request)
    {
        // Initialisez la requête de base avec les utilisateurs associés
        $query = Client::with('user');

        // Filtrage par comptes
        $comptes = $request->query('comptes');
        if ($comptes === 'oui') {
            $query->whereHas('user');
        } elseif ($comptes === 'non') {
            $query->doesntHave('user');
        }

        // Filtrage par statut actif
        $active = $request->query('active');
        if ($active === 'oui') {
            $query->whereHas('user', function ($query) {
                $query->where('etat', 'actif');
            });
        } elseif ($active === 'non') {
            $query->whereHas('user', function ($query) {
                $query->where('etat', 'inactif');
            });
        }

        // Filtrage par user_id (s'il est fourni dans la requête)
        $userId = $request->query('user_id');
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Paginer les résultats, par exemple 4 résultats par page
        $clients = $query->paginate(10);

        return ApiResponseService::success(ClientResource::collection($clients));
    }



    public function showWithUser($id)
    {
        $client = Client::with('user')->findOrFail($id);

        // Préparer la réponse API avec le client et l'utilisateur
        $responseData = [
            'client' => new ClientResource($client),
        ];

        return ApiResponseService::success($responseData);
    }


    public function showByTelephone(Request $request)
    {
        $telephone = $request->input('telephone');

        if (empty($telephone)) {
            return ApiResponseService::error('Numéro de téléphone requis.', 400);
        }

        $clients = Client::with('user') // Charge la relation 'user'
            ->where('telephone', $telephone)
            ->get();

        if ($clients->isEmpty()) {
            return ApiResponseService::error('Aucun client trouvé pour ce numéro de téléphone.', 404);
        }

        return ApiResponseService::success(ClientResource::collection($clients));
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return ApiResponseService::success(new ClientResource($client));
    }



    public function listDettes($id)
    {
        $client = Client::findOrFail($id);
        $dettes = Dette::where('client_id', $client->id)->get();

        // Vous pouvez créer une resource pour formater les dettes si nécessaire
        return ApiResponseService::success($dettes);
    }


    public function getToken()
    {
        if (!session()->has('_token')) {
            session()->regenerateToken();
        }

        return ApiResponseService::success(['csrf_token' => csrf_token()]);
    }

    public function store(StoreClientRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // Validation des données du client
            $clientData = $request->only(['surnom', 'prenom', 'adresse', 'telephone']);

            // Création du client
            $client = Client::create($clientData);

            // Vérifier si les informations de l'utilisateur sont fournies
            if ($request->has('login') && $request->has('password') && $request->has('role')) {
                // Validation des données de l'utilisateur
                $userRequestData = $request->only(['login', 'password', 'role']);

                // Récupération de l'ID du rôle
                $role = Role::where('libelle', $userRequestData['role'])->first();
                if (!$role) {
                    // Annuler la transaction si le rôle est invalide
                    DB::rollBack();
                    return ApiResponseService::error('Le rôle spécifié est invalide.', 400);
                }

                // Création de l'utilisateur
                $user = User::create([
                    'name' => "{$client->prenom} {$client->surnom}",
                    'login' => $userRequestData['login'],
                    'password' => Hash::make($userRequestData['password']),
                    'role_id' => $role->id,
                ]);

                // Association du client à l'utilisateur
                $client->user_id = $user->id;
                $client->save();
            }

            // Charger les données de l'utilisateur associé au client
            $client->load('user');

            // Préparer la réponse API avec le client et l'utilisateur
            $responseData = [
                'client' => new ClientResource($client)
            ];

            // Réponse API avec succès
            return ApiResponseService::success($responseData, 201);
        });
    }
}
