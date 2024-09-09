<?php

namespace App\Http\Controllers;

use App\Services\ArticleServiceInterface;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        // Vérifiez si des paramètres de filtrage sont présents
        if ($request->has('disponible')) {
            $filters = $request->only(['disponible']);
            return response()->json($this->articleService->findByFilters($filters));
        }
    
        // Si aucun paramètre n'est fourni, récupérez tous les articles
        return response()->json($this->articleService->all());
    }
    

    public function store(ArticleRequest $request)
    {
        $data = $request->validated();
        $article = $this->articleService->create($data);

        if ($article) {
            return ApiResponseService::success($article, 201);
        } else {
            return ApiResponseService::error('Échec de la création de l\'article.', 500);
        }
    }

    public function show($id)
    {
        $article = $this->articleService->find($id);

        if ($article) {
            return ApiResponseService::success($article, 200);
        } else {
            return ApiResponseService::error('Article non trouvé.', 404);
        }
    }

    public function update(ArticleRequest $request, $id)
    {
        $data = $request->validated();
        $article = $this->articleService->update($id, $data);

        if ($article) {
            return ApiResponseService::success($article, 200);
        } else {
            return ApiResponseService::error('Échec de la mise à jour de l\'article.', 500);
        }
    }

    public function destroy($id)
    {
        $success = $this->articleService->delete($id);

        if ($success) {
            return ApiResponseService::success('Article supprimé avec succès.', 200);
        } else {
            return ApiResponseService::error('Échec de la suppression de l\'article.', 500);
        }
    }

    public function findByLibelle($libelle){
        $article = $this->articleService->findByLibelle($libelle);

        if ($article) {
            return ApiResponseService::success($article, 200);
        } else {
            return ApiResponseService::error('Article non trouvé.', 404);
        }
    }
}
