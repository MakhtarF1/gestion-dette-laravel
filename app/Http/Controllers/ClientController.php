<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ClientServiceFacade as ClientService;
use App\Http\Resources\ClientResource;
use App\Http\Resources\DetteResource;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = ClientService::getAllClients($request->all());
        return ClientResource::collection($clients); // Pas besoin d'utiliser ApiResponseService ici
    }

    public function show($id)
    {
        $client = ClientService::findClient($id);
        return new ClientResource($client); // Pas besoin d'utiliser ApiResponseService ici
    }

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
        return new ClientResource($client); // Pas besoin d'utiliser ApiResponseService ici
    }

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
        return new ClientResource($client); // Pas besoin d'utiliser ApiResponseService ici
    }

    public function destroy($id)
    {
        ClientService::deleteClient($id);
        return response()->json(null, 204); // Pas besoin d'utiliser ApiResponseService ici
    }

    public function getDetteByClient($clientId)
    {
        $dette = ClientService::getDettesByClientId($clientId);
    
        if (!$dette->isEmpty()) {
            return DetteResource::collection($dette); // Pas besoin d'utiliser ApiResponseService ici
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucune dette associée au client.',
            ], 404);
        }
    }
}
