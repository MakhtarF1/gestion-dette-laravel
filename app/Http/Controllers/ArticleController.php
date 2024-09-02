<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ApiResponseService;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $disponible = $request->query('disponible');

        if ($disponible !== null) {
            if ($disponible === 'oui') {
                $articles = Article::where('quantitestock', '>', 0)->get();
            } elseif ($disponible === 'non') {
                $articles = Article::where('quantitestock', '=', 0)->get();
            } else {
                return ApiResponseService::error('Paramètre "disponible" invalide.', 400);
            }
        } else {
            $articles = Article::all();
        }

        return ApiResponseService::success($articles, 200);
    }


    public function FullUpdate(Request $request)
    {
        $articlesData = $request->input('articles'); // Tableau d'objets contenant 'id' et 'quantitestock'

        $Articles_Update = [];
        $failedUpdates = [];

        foreach ($articlesData as $articleData) {
            $article = Article::find($articleData['id']);

            if ($article && isset($articleData['quantitestock']) && $articleData['quantitestock'] > 0) {
                try {
                    // Mettre à jour la quantité de stock uniquement si la quantité est positive
                    $article->quantitestock += $articleData['quantitestock'];
                    $article->save();

                    $Articles_Update[] = $article;
                } catch (\Exception $e) {
                    // Ajouter l'article à la liste des échecs en cas d'erreur
                    $failedUpdates[] = [
                        'article' => $article,
                        'error' => $e->getMessage()
                    ];
                }
            } else {
                // Ajouter à la liste des échecs si l'article est introuvable ou si la quantité est incorrecte
                $failedUpdates[] = [
                    'articleData' => $articleData,
                    'error' => 'Article introuvable ou quantité incorrecte'
                ];
            }
        }

        // Retourner la réponse avec les articles mis à jour et ceux qui ont échoué
        return ApiResponseService::successWithMessage('Mise à jour effectuée', [
            'updated_articles' => $Articles_Update,
            'failed_updates' => $failedUpdates
        ], 200);
    }

    public function getByLibelle(Request $request)
    {
        $libelle = $request->input('libelle');
    
        if (!$libelle) {
            return ApiResponseService::error('Le libellé est obligatoire.', 400);
        }
    
        $article = Article::where('libelle', $libelle)->first();
    
        if ($article) {
            return ApiResponseService::successWithMessage('Article trouvé!', $article, 200);
        } else {
            // Retourner une réponse avec 'data' à null
            return ApiResponseService::error('Article non trouvé.', 411);
        }
    }
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $article = Article::where('libelle', $request->libelle)->first();

        if ($article) {
            return ApiResponseService::error('Le libellé existe déjà.', 401);
        }
    
        try {
            $newArticle = Article::create($request->all());
    
            return ApiResponseService::successWithMessage('Article enregistré avec succès!', $newArticle, 201);
        } catch (\Exception $e) {
            return ApiResponseService::error('Une erreur s\'est produite lors de l\'enregistrement de l\'article.', 401);
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return ApiResponseService::success($article, 200);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(ArticleRequest $request, Article $article)
    {
        if ($request->has('quantitestock')) {
            $article->quantitestock += $request->quantitestock;
        }

        $article->save();

        return ApiResponseService::successWithMessage('Article mis à jour!', $article, 200);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return ApiResponseService::successWithMessage('Article supprimé!', null, 200);
    }
}
