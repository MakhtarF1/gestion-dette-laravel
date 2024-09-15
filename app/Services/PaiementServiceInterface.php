<?php

namespace App\Services;

interface PaiementServiceInterface
{
    public function createPaiement(int $clientId, int $detteId, float $montant);
}
