<?php

namespace App\Services;

use App\Models\MongoDette; // Modèle pour MongoDB
use App\Models\Dette; // Modèle pour PostgreSQL
use Illuminate\Support\Facades\Log;

class MongoArchiveDetteService implements ArchiveDetteServiceInterface
{
    public function archivePaidDettes()
    {
        $dettes = Dette::with(['paiements', 'articles'])->get();

        foreach ($dettes as $dette) {
            $totalPaiements = $dette->paiements->sum('montant');

            if ($totalPaiements >= $dette->montant_dette) {
                // Préparer les données à archiver
                $data = [
                    'client_id' => $dette->client_id,
                    'montant_dette' => $dette->montant_dette,
                    'articles' => $dette->articles->map(function ($article) {
                        return [
                            'id' => $article->id,
                            'libelle' => $article->libelle,
                            'prix' => $article->prix,
                            'qte' => $article->qte,
                        ];
                    })->toArray(),
                    'created_at' => $dette->created_at,
                    'updated_at' => $dette->updated_at,
                ];

                // Enregistrer dans MongoDB
                MongoDette::create($data);
                Log::info('Dette archivée dans MongoDB.', ['dette' => $data]);

                // Supprimer la dette de PostgreSQL
                $dette->delete();
                Log::info('Dette supprimée de PostgreSQL.', ['dette_id' => $dette->id]);
            }
        }
    }
}
