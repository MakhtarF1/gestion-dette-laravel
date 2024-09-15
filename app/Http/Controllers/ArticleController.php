<?php

namespace App\Http\Controllers;

use App\Services\ArticleServiceInterface;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\StockUpdateRequest;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Exceptions\ArticleNotFoundException;
use App\Exceptions\ArticleCreationException;
use Exception;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        try {
            if ($request->has('disponible')) {
                $filters = $request->only(['disponible']);
                $articles = $this->articleService->findByFilters($filters);
                return ApiResponseService::success($articles, 200);
            }

            $articles = $this->articleService->all();
            return ApiResponseService::success($articles, 200);
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la récupération des articles.', 500);
        }
    }

    public function findByLibelle($libelle)
    {
        try {
            $article = $this->articleService->findByLibelle($libelle);
            // dd($article);
            if ($article) {
                return ApiResponseService::success($article, 200);
            } else {
                throw new ArticleNotFoundException();
            }
        } catch (ArticleNotFoundException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la recherche de l\'article par libellé.', 500);
        }
    }

    public function findById($id)
    {
        try {
            $article = $this->articleService->find($id);

            if ($article) {
                return ApiResponseService::success($article, 200);
            } else {
                throw new ArticleNotFoundException();
            }
        } catch (ArticleNotFoundException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la recherche de l\'article par ID.', 500);
        }
    }

    public function store(ArticleRequest $request)
    {
        try {
            $data = $request->validated();
            $article = $this->articleService->create($data);

            if ($article) {
                return ApiResponseService::success($article, 201, 'Article créé avec succès.');
            } else {
                throw new ArticleCreationException();
            }
        } catch (ArticleCreationException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la création de l\'article.', 500);
        }
    }

    public function show($article)
    {
        try {
            $article = $this->articleService->find($article);

            if ($article) {
                return ApiResponseService::success($article, 200);
            } else {
                throw new ArticleNotFoundException();
            }
        } catch (ArticleNotFoundException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la récupération de l\'article.', 500);
        }
    }




    public function update(ArticleRequest $request, $article)
    {
        try {
            $data = $request->validated();
            $article = $this->articleService->update($article, $data);

            if ($article) {
                return ApiResponseService::success($article, 200, 'Article mis à jour avec succès.');
            } else {
                throw new ArticleNotFoundException();
            }
        } catch (ArticleNotFoundException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la mise à jour de l\'article.', 500);
        }
    }

    public function destroy($article)
    {
        try {
            $success = $this->articleService->delete($article);

            if ($success) {
                return ApiResponseService::success(null, 200, 'Article supprimé avec succès.');
            } else {
                throw new ArticleNotFoundException();
            }
        } catch (ArticleNotFoundException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la suppression de l\'article.', 500);
        }
    }

    public function updateStock(Request $request, $article)
    {
        try {
            $validated = $request->validate([
                'quantitestock' => 'required|numeric|min:0',
            ]);

            $article = $this->articleService->updateStock($article, $validated['quantitestock']);

            if ($article) {
                return ApiResponseService::success($article, 200, 'Quantité de stock mise à jour.');
            } else {
                throw new ArticleNotFoundException();
            }
        } catch (ArticleNotFoundException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return ApiResponseService::error('Une erreur est survenue lors de la mise à jour du stock.', 500);
        }
    }

    public function updateMultipleStocks(StockUpdateRequest $request)
    {
        try {
            $articles = $request->validated()['articles'];
            $updatedArticles = $this->articleService->updateStockBatch($articles);

            if (!empty($updatedArticles)) {
                return ApiResponseService::success($updatedArticles, 200, 'Stock mis à jour pour les articles.');
            } else {
                throw new Exception('Échec de la mise à jour des articles.');
            }
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }
}
