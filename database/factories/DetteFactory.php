<?php

namespace Database\Factories;

use App\Models\Dette;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetteFactory extends Factory
{
    protected $model = Dette::class;

    public function definition()
    {
        return [
            'client_id' => Client::factory(), // Créer un client associé
            'montant_dette' => $this->faker->randomFloat(2, 100, 10000), // Montant de la dette entre 100 et 10000
        ];
    }
}
