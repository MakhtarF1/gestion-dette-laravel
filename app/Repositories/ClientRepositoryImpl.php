<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientRepositoryImpl implements ClientRepositoryInterface
{
    public function all(array $params = [])
    {
        $query = Client::with('user');

        // Filtrage par état actif
        if (isset($params['active'])) {
            $params['active'] === 'oui' ? $query->isActive() : $query->isInactive();
        }
        // Filtrage par compte
        elseif (isset($params['compte'])) {
            $params['compte'] === 'oui'
                ? $query->whereNotNull('user_id')
                : $query->whereNull('user_id');
        }elseif(isset($params['role'])){


        }

        return $query->get();
    }

    

    public function findWithUser(int $id): Client
    {
        $client = Client::with('user')->find($id);

        if (!$client) {
            throw new ModelNotFoundException("Client non trouvé");
        }

        return $client;
    }

    public function findByTelephone(string $telephone): ?Client
    {
        return Client::where('telephone', $telephone)->first();
    }

    public function find(int $id): Client
    {
        $client = Client::with('user')->find($id);

        if (!$client) {
            throw new ModelNotFoundException("Client not found");
        }

        return $client;
    }

    public function create(array $data): Client
    {
        return Client::create([
            'surname' => $data['surname'],
            'telephone' => $data['telephone'],
            'adresse' => $data['adresse'] ?? '',
            'categorie_id' => $data['categorie_id'], 
            'max_montant' => $data['max_montant'],
        ]);
    }
    
    
    public function update(int $id, array $data): Client
    {
        $client = $this->find($id);
        $client->update($data);
        return $client;
    }

    public function delete(int $id): bool
    {
        $client = $this->find($id);
        return $client->delete();
    }

    public function getDettesByClientId(int $clientId)
    {
        $client = Client::with('dettes')->find($clientId);

        if (!$client) {
            throw new ModelNotFoundException("Client non trouvé");
        }

        return $client->dettes;
    }


    
}
