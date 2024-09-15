<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use App\Models\Dette;
use App\Models\Paiement;

class FireBaseService implements ServiceArchiveInterface
{
    protected $database;

    public function __construct()
    {
        $credentialsPath = env('FIREBASE_CREDENTIALS');
        $databaseUrl = env('FIREBASE_DATABASE_URL');

        if (is_null($credentialsPath) || is_null($databaseUrl)) {
            throw new \Exception('Firebase credentials or database URL is not set.');
        }

        $firebase = (new Factory)
            ->withServiceAccount($credentialsPath)
            ->withDatabaseUri($databaseUrl);

        $this->database = $firebase->createDatabase();
    }

    public function archiveDette(Dette $dette)
    {
        $totalPaiements = Paiement::where('dette_id', $dette->id)->sum('montant');

        if ($totalPaiements >= $dette->montant_dette) {
            $articles = $dette->articles()->get()->map(function ($article) {
                return [
                    'description' => $article->description,
                    'quantite' => $article->quantite,
                    'prix_unitaire' => $article->prix_unitaire,
                ];
            });

            // Archivez la dette et les articles dans Firebase
            $this->database->getReference('dettes/' . $dette->id)->set([
                'montant_dette' => $dette->montant_dette,
                'articles' => $articles,
                // autres champs
            ]);
        }
    }
}
