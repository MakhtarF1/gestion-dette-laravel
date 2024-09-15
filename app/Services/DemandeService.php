<?php

namespace App\Services;

use App\Repositories\DemandeRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Demande;
use Exception;

class DemandeService
{
    protected $demandeRepository;

    public function __construct(DemandeRepository $demandeRepository)
    {
        $this->demandeRepository = $demandeRepository;
    }

    public function createDemande(array $data): Demande
    {
        DB::beginTransaction();

        try {
            $demande = $this->demandeRepository->create($data);

            // Envoyer une notification après la création de la demande
            DB::commit();
            return $demande;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e; 
        }
    }

    public function getAllDemandes()
    {
        return $this->demandeRepository->getAll();
    }

    public function getDemandesForClient($clientId)
    {
        return $this->demandeRepository->findByClient($clientId);
    }

    public function findDemande($id): ?Demande
    {
        return $this->demandeRepository->find($id);
    }

    public function updateStatus($id, $status): ?Demande
    {
        return $this->demandeRepository->updateStatus($id, $status);
    }
}
