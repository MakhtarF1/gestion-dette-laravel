<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dette;
use App\Models\Article;

class DetteArticleFactory extends Factory
{
    protected $model = \Illuminate\Database\Eloquent\Model::class; // Pas de modèle spécifique

    public function definition(): array
    {
        return [
            'dette_id' => Dette::factory(),
            'article_id' => Article::factory(),
            'quantite' => $this->faker->numberBetween(1, 10),
            'prix' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
