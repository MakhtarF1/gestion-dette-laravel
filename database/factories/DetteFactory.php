<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dette>
 */
class DetteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(), // Crée un client associé
            'montant_pa' => $this->faker->randomFloat(2, 100, 1000),
            'montant_rst' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
