<?php

namespace App\Repositories;

use App\Models\Dette;
use App\Models\Article;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Exception;

class DetteRepositoryImpl implements DetteRepositoryInterface
{
    public function createDette($clientId, $articlesData)
    {
        DB::beginTransaction();

        try {
            $articleExists = [];
            $articleNotExists = [];
            $totalAmount = 0;

            // Vérifier l'existence des articles
            foreach ($articlesData as $articleData) {
                $article = Article::find($articleData['id']);
                if ($article) {
                    $articleExists[] = $articleData;
                    // Calcul du montant
                    $amount = $articleData['quantite'] * $articleData['prixVente'];
                    $totalAmount += $amount;
                } else {
                    $articleNotExists[] = $articleData['id'];
                }
            }

            // Enregistrer la dette
            $dette = Dette::create([
                'client_id' => $clientId,
                'montant_dette' => $totalAmount,
            ]);

            // Enregistrer les articles de la dette
            foreach ($articleExists as $articleData) {
                $article = Article::find($articleData['id']);
                $article->dettes()->attach($dette->id, [
                    'quantite' => $articleData['quantite'],
                    'prix' => $articleData['prixVente'],
                ]);
            }

            DB::commit();

            return [
                'dette' => $dette,
                'articleExists' => $articleExists,
                'articleNotExists' => $articleNotExists,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function addPaiement($dette_id, $client_id,$montantPaiement)
    {
        $clientId = Client::findOrFail($client_id);
        if ($clientId) {
            $dette = Dette::findOrFail($dette_id);
            if ($dette) {
                $montantPaiement = request()->input('montant_paiement');
                if ($montantPaiement <= $dette->montant_dette) {
                    $dette->montant_dette -= $montantPaiement;
                    $dette->save();
                    return ['message' => 'Paiement effectué avec succès'];
                } else {
                    return ['error' => 'Montant du paiement supérieur au montant de la dette'];
                }
            } else {
                return ['error' => 'Dette introuvable'];
            }
        }
    }




    public function getAllDettes()
    {
        return Dette::with('client', 'articles')->get();
    }
}
