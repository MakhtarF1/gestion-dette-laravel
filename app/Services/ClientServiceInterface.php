<?php

namespace App\Services;

interface ClientServiceInterface
{
    public function getAllClients($filters);
    public function findClient($id);
    public function createClient(array $data);
    public function updateClient($id, array $data);
    public function deleteClient($id);
}
