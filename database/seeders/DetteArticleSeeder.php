<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Dette;

class DetteArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les articles et dettes existants
        $articles = Article::all();
        $dettes = Dette::all();

        // Pour chaque dette, associer des articles aléatoires
        foreach ($dettes as $dette) {
            // Choisir un nombre aléatoire d'articles à associer à cette dette
            $selectedArticles = $articles->random(rand(1, 5)); // Par exemple, entre 1 et 5 articles

            foreach ($selectedArticles as $article) {
                // Associer l'article à la dette avec une quantité aléatoire
                $dette->articles()->attach($article->id, ['quantite' => rand(1, 10)]);
            }
        }
    }
}
