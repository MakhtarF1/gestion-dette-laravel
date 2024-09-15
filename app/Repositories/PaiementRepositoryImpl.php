<?php

namespace App\Repositories;

use App\Models\Paiement;

class PaiementRepositoryImpl implements PaiementRepositoryInterface
{
    public function create(array $data)
    {
        return Paiement::create($data);
    }
}
