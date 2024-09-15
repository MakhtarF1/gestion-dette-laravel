<?php

namespace App\Repositories;

use App\Models\Dette;

interface DetteRepositoryInterface
{
    public function createDette($clientId, $articlesData);
    public function addPaiement($dette_id,$client_id,$montantPaiement);
    public function getAllDettes();
}
