<?php

namespace App\Services;

use App\Repositories\ArticleRepositoryInterface;


class ArticleServiceImpl implements ArticleServiceInterface
{
    protected $repo;

    public function __construct(ArticleRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function all(array $params = [])
    {
        return $this->repo->all($params);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function findByLibelle($libelle)
    {
        return $this->repo->findByLibelle($libelle);
    }

    public function findByEtat($etat)
    {
        return $this->repo->findByEtat($etat);
    }

    public function findByFilters(array $filters)
    {
        return $this->repo->findByFilters($filters);
    }

    public function updateStock($id, $qteStock)
    {
        return $this->repo->updateStock($id, $qteStock);
    }

    public function incrementStock($id, $qteStock)
    {
        $article = $this->repo->find($id);
    
        if ($article) {
            $article->quantitestock += $qteStock;
            $article->save();
    
            return $article;
        }
    
        return null;
    }
    
    public function updateStockBatch(array $articles)
    {
        $updatedArticles = [];
    
        foreach ($articles as $articleData) {
            $updatedArticle = $this->incrementStock($articleData['id'], $articleData['qteStock']);
            if ($updatedArticle) {
                $updatedArticles[] = $updatedArticle;
            }
        }
    
        return $updatedArticles;
    }
}
