<?php

namespace App\Services;

use App\Repositories\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;




class ClientServiceImpl implements ClientServiceInterface
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAllClients(array $filters)
    {
        return $this->clientRepository->all($filters);
    }

    public function findClient(int $id)
    {
        return $this->clientRepository->find($id);
    }

    public function createClient(array $data)
    {
        return $this->clientRepository->create($data);
    }

    public function updateClient(int $id, array $data)
    {
        return $this->clientRepository->update($id, $data);
    }

    public function deleteClient(int $id)
    {
        return $this->clientRepository->delete($id);
    }

    public function getDettesByClientId(int $clientId)
    {
        return $this->clientRepository->getDettesByClientId($clientId);
    }

    public function findClientWithUser(int $id)
    {
        return $this->clientRepository->findWithUser($id);
    }

    public function findClientByTelephone(string $telephone)
    {
        $client = $this->clientRepository->findByTelephone($telephone);

        if (!$client) {
            throw new ModelNotFoundException('Client non trouvé');
        }

        return $client;
    }
    
}
