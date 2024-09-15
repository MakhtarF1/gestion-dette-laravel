<?php

namespace App\Services;

interface DetteServiceInterface
{
    public function createDette($clientId, $articlesData);
    public function addPaiement($dette_id,$client_id,$montant_paiement);
    public function getAllDettes();
}