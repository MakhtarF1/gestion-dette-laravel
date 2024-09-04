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

    public function getDettesByClientId($clientId)
    {
        return $this->clientRepository->getDettesByClientId($clientId);
    }

    public function getAllClients($filters)
    {
        return $this->clientRepository->all($filters);
    }

    public function findClient($id)
    {
        return $this->clientRepository->find($id);
    }

    public function createClient(array $data)
    {
        return $this->clientRepository->create($data);
    }

    public function updateClient($id, array $data)
    {
        return $this->clientRepository->update($id, $data);
    }

    public function deleteClient($id)
    {
        return $this->clientRepository->delete($id);
    }
}
