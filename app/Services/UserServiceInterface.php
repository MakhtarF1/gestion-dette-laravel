<?php

namespace App\Services;

interface UserServiceInterface
{
    public function getAllUsers($filters);
    public function getUserById($id);
    public function createUser($data);
    public function updateUser($id, $data);
    public function deleteUser($id);
}
