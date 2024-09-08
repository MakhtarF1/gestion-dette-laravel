<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Facades\ClientServiceFacade as ClientService;
use App\Http\Resources\ClientResource;
use App\Http\Resources\DetteResource;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = ClientService::getAllClients($request->all());
        return ClientResource::collection($clients);
    }

    public function show(int $id)
    {
        $client = ClientService::findClient($id);
        return new ClientResource($client);
    }

    public function store(StoreClientRequest $request)
    {
        $validatedData = $request->validated();
        $client = ClientService::createClient($validatedData);
        return new ClientResource($client, 201);
    }

    public function update(StoreClientRequest $request, int $id)
    {
        $validatedData = $request->validated();
        $client = ClientService::updateClient($id, $validatedData);
        return new ClientResource($client);
    }

    public function destroy(int $id)
    {
        ClientService::deleteClient($id);
        return response()->json(null, 204);
    }

    public function getDetteByClient(int $clientId)
    {
        $dette = ClientService::getDettesByClientId($clientId);
    
        if ($dette && !$dette->isEmpty()) {
            return DetteResource::collection($dette);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucune dette associée au client.',
            ], 404);
        }
    }

    public function findByTelephone(Request $request)
    {
        $telephone = $request->input('telephone');

        if (!$telephone) {
            return response()->json(['error' => 'Le numéro de téléphone est requis'], 400);
        }

        try {
            $client = ClientService::findClientByTelephone($telephone);
            return new ClientResource($client);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
