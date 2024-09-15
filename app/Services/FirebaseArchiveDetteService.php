<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use App\Models\Dette; // Modèle pour PostgreSQL
use Illuminate\Support\Facades\Log;

class FirebaseArchiveDetteService implements ArchiveDetteServiceInterface
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(env('FIREBASE_CREDENTIALS'));
        $this->database = $factory->createDatabase();
    }

    public function archivePaidDettes()
    {
        $dettes = Dette::with(['paiements', 'articles'])->get();

        foreach ($dettes as $dette) {
            $totalPaiements = $dette->paiements->sum('montant');

            if ($totalPaiements >= $dette->montant_dette) {
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

                // Enregistrer dans Firebase
                $this->database->getReference('dettes/' . $dette->id)->set($data);
                Log::info('Dette archivée dans Firebase.', ['dette' => $data]);

                // Supprimer la dette de PostgreSQL
                $dette->delete();
                Log::info('Dette supprimée de PostgreSQL.', ['dette_id' => $dette->id]);
            }
        }
    }
}
