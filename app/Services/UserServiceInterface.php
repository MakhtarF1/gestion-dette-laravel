<?php

namespace App\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function create(array $data): User;

    public function createUserAndClient(array $data);

    public function getAllUsers(array $filters);

    public function getUserById(int $id);

    public function updateUser(int $id, array $data);

    public function deleteUser(int $id);
}
