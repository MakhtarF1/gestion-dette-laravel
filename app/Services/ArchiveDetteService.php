<?php

namespace App\Services;

use App\Models\MongoDette; // Modèle pour MongoDB
use App\Models\Dette; // Modèle pour PostgreSQL
use Illuminate\Support\Facades\Log;

class ArchiveDetteService
{
    public function archivePaidDettes()
    {
        // Récupérer toutes les dettes avec les articles
        $dettes = Dette::with(['paiements', 'articles'])->get();

        foreach ($dettes as $dette) {
            $totalPaiements = $dette->paiements->sum('montant');

            // Vérifier si le montant de la dette est égal à la somme des paiements
            if ($totalPaiements >= $dette->montant_dette) {
                // Créer une entrée dans MongoDB
                $mongoDette = new MongoDette();
                
                // Préparer les données à archiver
                $mongoData = [
                    'client_id' => $dette->client_id,
                    'montant_dette' => $dette->montant_dette,
                    'articles' => $dette->articles->map(function ($article) {
                        return [
                            'id' => $article->id,
                            'libelle' => $article->libelle,
                            'prix' => $article->prix,
                            'qte' => $article->qte,
                            'created_at' => $article->created_at,
                            'updated_at' => $article->updated_at,
                        ];
                    })->toArray(),
                    'created_at' => $dette->created_at,
                    'updated_at' => $dette->updated_at,
                ];

                $mongoDette->fill($mongoData);
                $mongoDette->save();

                Log::info('Dette archivée dans MongoDB.', ['dette' => $mongoDette]);

                // Supprimer la dette de PostgreSQL
                $dette->delete();
                Log::info('Dette supprimée de PostgreSQL.', ['dette_id' => $dette->id]);
            }
        }
    }
}
