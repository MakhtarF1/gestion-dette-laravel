<?php

namespace App\Services;

interface ClientServiceInterface
{
    public function getAllClients(array $filters);
    public function findClient(int $id);
    public function createClient(array $data);
    public function updateClient(int $id, array $data);
    public function deleteClient(int $id);
    public function getDettesByClientId(int $clientId);
    
}
