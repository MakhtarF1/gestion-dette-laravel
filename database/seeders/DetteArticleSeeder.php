<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Dette; // Assurez-vous que ce modèle existe
use App\Models\Article; // Assurez-vous que ce modèle existe
use Faker\Factory as Faker; // Importez Faker

class DetteArticleSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create(); // Initialisez Faker
    }

    public function run()
    {
        // Récupérez tous les ID des dettes et articles existants
        $dettesIds = Dette::pluck('id')->toArray();
        $articlesIds = Article::pluck('id')->toArray();

        // Créez des enregistrements pour la table pivot
        $detteArticleData = [];

        for ($i = 0; $i < 30; $i++) {
            $detteArticleData[] = [
                'dette_id' => $this->faker->randomElement($dettesIds),
                'article_id' => $this->faker->randomElement($articlesIds),
                'quantite' => rand(1, 10), // Exemple de quantité
                'prix' => $this->faker->randomFloat(2, 1, 100), // Exemple de prix
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insérez les enregistrements dans la table pivot
        DB::table('dette_article')->insert($detteArticleData);
    }
}
