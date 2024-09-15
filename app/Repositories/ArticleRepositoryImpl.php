<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepositoryImpl implements ArticleRepositoryInterface
{
    public function all(array $params = [])
    {
        $query = Article::query();

        if (isset($params['disponible'])) {
            if ($params['disponible'] === 'oui') {
                $query->where('quantitestock', '>', 0);
            } elseif ($params['disponible'] === 'non') {
                $query->where('quantitestock', '=', 0);
            }
        }
        return $query->get();
    }


    public function create(array $data)
    {
        return Article::create($data);
    }

    public function find($id)
    {
        return Article::find($id);
    }

    public function update($id, array $data)
    {
        $article = $this->find($id);
        if ($article) {
            $article->update($data);
            return $article;
        }
        return null;
    }

    public function delete($id)
    {
        $article = $this->find($id);
        if ($article) {
            $article->delete();
            return true;
        }
        return false;
    }

    public function findByLibelle($libelle)
    {
        return Article::where('libelle',trim($libelle))->first();
    }

    public function findByEtat($etat)
    {
        // Implémentez la logique pour trouver par état
    }

    public function findByFilters(array $filters)
    {
        $query = Article::query();

        if (isset($filters['disponible'])) {
            $query->disponible($filters['disponible']);
        }

        return $query->get();
    }

    public function updateStock($id, $qteStock)
    {
        $article = $this->find($id);
        if ($article) {
            $article->quantitestock += $qteStock;
            $article->save();
            return $article;
        }
        return null;
    }

    public function incrementStock($id, $qteStock)
    {
        $article = Article::find($id);

        if ($article) {
            // Incrémenter la quantité en stock
            $article->quantitestock += $qteStock;
            $article->save();

            return $article;
        }

        return null;
    }


    
}
