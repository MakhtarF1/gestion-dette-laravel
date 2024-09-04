<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function all($filters);
    public function findById($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
}
