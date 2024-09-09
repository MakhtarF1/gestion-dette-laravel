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

    // Récupérer tous les articles
    public function all(array $params = [])
    {
        return $this->repo->all($params); // Récupère tous les articles
    }

    // Créer un nouvel article
    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    // Trouver un article par ID
    public function find($id)
    {
        return $this->repo->find($id);
    }

    // Mettre à jour un article
    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    // Supprimer un article
    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    // Trouver un article par libellé
    public function findByLibelle($libelle)
    {
        return $this->repo->findByLibelle($libelle);
    }

    // Trouver un article par état
    public function findByEtat($etat)
    {
        return $this->repo->findByEtat($etat);
    }

    // Trouver des articles par filtres
    public function findByFilters(array $filters)
    {
        return $this->repo->findByFilters($filters); // Appel à la méthode du repository
    }
}
