<?php

namespace App\Repositories;

use App\Models\Client;

interface ClientRepositoryInterface
{
    public function all(array $params = []);
    public function find(int $id): Client;
    public function create(array $data): Client;
    public function update(int $id, array $data): Client;
    public function delete(int $id): bool;
    public function getDettesByClientId(int $clientId);
    public function findWithUser(int $id): Client;
    public function findByTelephone(string $telephone): ?Client;
}
