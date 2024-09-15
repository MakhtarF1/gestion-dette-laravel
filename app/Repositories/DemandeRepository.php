<?php

namespace App\Repositories;

use App\Models\Demande;
use Illuminate\Support\Facades\Auth;

class DemandeRepository
{
    public function create(array $data): Demande
    {
        $user = Auth::user();

        if (!$user || !$user->client) {
            throw new \Exception('Client non trouvé pour l\'utilisateur authentifié.');
        }

        $data['client_id'] = $user->client->id;

        $demande = Demande::create($data);

        if (isset($data['articles']) && is_array($data['articles'])) {
            foreach ($data['articles'] as $article) {
                $demande->articles()->attach($article['article_id'], [
                    'quantite' => $article['quantite'],
                    'prix' => $article['prix'] ?? null,
                ]);
            }
        }

        return $demande;
    }

    public function getAll()
    {
        return Demande::with('client', 'articles')->get();
    }

    public function find($id): ?Demande
    {
        return Demande::with('client', 'articles')->find($id);
    }

    public function updateStatus($id, $status): ?Demande
    {
        $demande = $this->find($id);

        if ($demande) {
            $demande->update(['statut' => $status]);
            return $demande;
        }

        return null;
    }

    public function findByClient($clientId)
    {
        return Demande::where('client_id', $clientId)->with('client', 'articles')->get();
    }
}
