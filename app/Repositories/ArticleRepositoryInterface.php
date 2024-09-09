<?php

namespace App\Repositories;

interface ArticleRepositoryInterface
{
    public function all(array $params = []);

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function findByLibelle($libelle);

    public function findByEtat($etat);

    public function findByFilters(array $filters); // Cette ligne doit être présente
}
