<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ClientServiceFacade as ClientService;
use App\Http\Resources\ClientResource;
use App\Services\ApiResponseService;
use App\Http\Resources\DetteResource;

class ClientController extends Controller
{
    // Récupérer tous les clients
    public function index(Request $request)
    {
        $clients = ClientService::getAllClients($request->all());
        return ApiResponseService::success(ClientResource::collection($clients));
    }

    // Récupérer un client spécifique
    public function show($id)
    {
        $client = ClientService::findClient($id);
        return ApiResponseService::success(new ClientResource($client));
    }

    // Créer un nouveau client
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'surnom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'user_id' => 'required|exists:users,id',
        ]);

        $client = ClientService::createClient($validatedData);
        return ApiResponseService::success(new ClientResource($client), 201);
    }

    // Mettre à jour un client existant
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'surnom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'adresse' => 'sometimes|required|string|max:255',
            'telephone' => 'sometimes|required|string|max:20',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $client = ClientService::updateClient($id, $validatedData);
        return ApiResponseService::success(new ClientResource($client));
    }

    // Supprimer un client
    public function destroy($id)
    {
        ClientService::deleteClient($id);
        return ApiResponseService::success(null, 204);
    }


    public function getDetteByClient($clientId)
    {
        $dette = ClientService::getDettesByClientId($clientId);
    
        if (!$dette) {
            return ApiResponseService::error('Client non trouvé ou aucune dette associée.', 404);
        }
    
        return ApiResponseService::success(DetteResource::collection($dette));
    }
    
}
