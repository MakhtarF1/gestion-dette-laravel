<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Dette;
use App\Repositories\PaiementRepositoryInterface;

class PaiementServiceImpl implements PaiementServiceInterface
{
    protected $paiementRepository;

    public function __construct(PaiementRepositoryInterface $paiementRepository)
    {
        $this->paiementRepository = $paiementRepository;
    }

    public function createPaiement(int $clientId, int $detteId, float $montant)
    {
        $client = Client::find($clientId);
        if (!$client) {
            throw new \Exception('Client not found');
        }

        $dette = Dette::find($detteId);
        if (!$dette) {
            throw new \Exception('Debt not found');
        }
        // dd($dette);
        if (!$client->dettes()->where('id', $detteId)->exists()) {
            throw new \Exception('Client does not have the specified debt');
        }

        if ($montant <= 0) {
            throw new \Exception('Amount must be greater than zero');
        }

        if ($montant > $dette->montant_dette) {
            throw new \Exception('Amount exceeds the debt amount');
        }

        $totalPayments = $dette->paiements()->sum('montant');

        if (($totalPayments + $montant) > $dette->montant_dette) {
            throw new \Exception('Total payments exceed the debt amount');
        }

        $paiementData = [
            'client_id' => $clientId,
            'dette_id' => $detteId,
            'montant' => $montant,
        ];

        // dd($paiementData);

        return $this->paiementRepository->create($paiementData);
    }
}
