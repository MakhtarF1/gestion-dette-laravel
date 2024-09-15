<?php

namespace App\Services;

use App\Repositories\DetteRepositoryInterface;
use App\Models\Article;
use Exception;

class DetteServiceImpl implements DetteServiceInterface
{
    protected $detteRepository;

    public function __construct(DetteRepositoryInterface $detteRepository)
    {
        $this->detteRepository = $detteRepository;
    }

    public function createDette($clientId, $articlesData)
    {
        return $this->detteRepository->createDette($clientId, $articlesData);
    }

    public function addPaiement($dette_id,$client_id,$montant_paiement){
        return $this->detteRepository->addPaiement($dette_id, $client_id,$montant_paiement);
    }

    public function getAllDettes(){
        return $this->detteRepository->getAllDettes();
    }
  
}
