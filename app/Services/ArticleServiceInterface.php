<?php

namespace App\Services;

interface ArticleServiceInterface
{
    public function all(array $params = []);

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function findByLibelle($libelle);

    public function findByEtat($etat);

    public function findByFilters(array $filters);

    public function updateStock($id, $qteStock);

    public function incrementStock($id, $qteStock);

    public function updateStockBatch(array $articles);
}
