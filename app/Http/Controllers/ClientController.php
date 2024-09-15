<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Facades\ClientServiceFacade as ClientService;
use App\Http\Resources\ClientResource;
use App\Http\Resources\DetteResource;
use App\Exceptions\ClientNotFoundException;
use App\Exceptions\ClientCreationException;
use Exception;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            $clients = ClientService::getAllClients($request->all());
            return ClientResource::collection($clients);
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des clients.'], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $client = ClientService::findClient($id);

            if (!$client) {
                throw new ClientNotFoundException();
            }

            return new ClientResource($client);
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération du client.'], 500);
        }
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $client = ClientService::createClient($validatedData);
    
            if (!$client) {
                throw new ClientCreationException();
            }
    
            return new ClientResource($client, 201);
        } catch (ClientCreationException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la création du client.'], 500);
        }
    }
    

    public function update(StoreClientRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();
            $client = ClientService::updateClient($id, $validatedData);

            if (!$client) {
                throw new ClientNotFoundException();
            }

            return new ClientResource($client);
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour du client.'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $success = ClientService::deleteClient($id);

            if (!$success) {
                throw new ClientNotFoundException();
            }

            return response()->json("Client supprimé avec succès", 204);
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression du client.'], 500);
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

            if (!$client) {
                throw new ClientNotFoundException('Client non trouvé pour ce numéro de téléphone');
            }

            return new ClientResource($client);
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function showWithUser(int $id)
    {
        try {
            $client = ClientService::findClient($id);

            if (!$client) {
                throw new ClientNotFoundException();
            }

            return new ClientResource($client->load('user'));
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération du client avec l\'utilisateur.'], 500);
        }
    }

    public function showByTelephone(Request $request)
    {
        $telephone = $request->input('telephone');

        if (!$telephone) {
            return response()->json(['error' => 'Le numéro de téléphone est requis'], 400);
        }

        try {
            $client = ClientService::findClientByTelephone($telephone);

            if (!$client) {
                throw new ClientNotFoundException('Client non trouvé pour ce numéro de téléphone');
            }

            return new ClientResource($client->load('user'));
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getDetteByClient(int $clientId)
    {
        try {
            $dettes = ClientService::getDettesByClientId($clientId);

            if ($dettes->isEmpty()) {
                return response()->json(['error' => 'Aucune dette trouvée pour ce client'], 404);
            }

            return DetteResource::collection($dettes);
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des dettes.'], 500);
        }
    }
}
