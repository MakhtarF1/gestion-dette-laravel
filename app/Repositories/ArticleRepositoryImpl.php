<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepositoryImpl implements ArticleRepositoryInterface
{
    public function all(array $params = [])
    {
        // Implémentez la logique de récupération des articles ici
        return Article::all();
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
        return Article::where('libelle', $libelle)->first();
    }

    public function findByEtat($etat)
    {
        // Implémentez la logique pour trouver par état
    }
}
