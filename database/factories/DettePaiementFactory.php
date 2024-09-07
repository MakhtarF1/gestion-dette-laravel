<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dette;
use App\Models\Paiement;

class DettePaiementFactory extends Factory
{
    // Pas besoin de spécifier le modèle si vous n'en avez pas
    protected $model = \Illuminate\Database\Eloquent\Model::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dette_id' => Dette::factory(), // Crée une dette associée
            'paiement_id' => Paiement::factory(), // Crée un paiement associé
            'montant' => $this->faker->randomFloat(2, 10, 1000), // Montant du paiement
        ];
    }
}
