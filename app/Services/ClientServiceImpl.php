<?php

namespace App\Services;

use App\Repositories\ClientRepositoryInterface;

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
}
