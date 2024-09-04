<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepositoryImpl implements ClientRepositoryInterface
{
    public function all(array $params = [])
    {
        $query = Client::with('user');
        if (isset($params['active'])) {
            if ($params['active'] === 'oui') {
                $query->isActive(); 
            } else {
                $query->isInactive(); 
            }
        } elseif (isset($params['compte'])) {
            if($params['compte']==='oui'){
                $query->whereNotNull('user_id');
            }else{
                $query->whereNull('user_id');
            }
        
        }
        return $query->get(); 
    }
    

    public function find($id)
    {
        return Client::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function update($id, array $data)
    {
        $client = $this->find($id);
        $client->update($data);
        return $client;
    }

    public function delete($id)
    {
        $client = $this->find($id);
        return $client->delete();
    }

    public function getDettesByClientId($clientId)
    {
        $client = Client::with('dette')->find($clientId);

        if (!$client) {
            return null;
        }

        return $client->dette; // Assurez-vous que la relation 'dette' est définie dans le modèle Client
    }
}
