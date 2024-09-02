<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = \App\Models\Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'libelle' => $this->faker->word(),
            'prix' => $this->faker->randomFloat(2, 1, 100), // Prix entre 1 et 100
            'quantitestock' => $this->faker->numberBetween(1, 50), // Stock entre 1 et 50
        ];
    }
}
