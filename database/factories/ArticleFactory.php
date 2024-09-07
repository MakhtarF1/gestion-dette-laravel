<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'libelle' => $this->faker->word,
            'prix' => $this->faker->randomFloat(2, 1, 100),
            'quantitestock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
