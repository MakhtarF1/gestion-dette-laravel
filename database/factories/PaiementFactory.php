<?php

namespace Database\Factories;

use App\Models\Paiement;
use App\Models\Client;
use App\Models\Dette;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    protected $model = Paiement::class;

    public function definition()
    {
        return [
            'client_id' => Client::factory(), // Créer un client associé
            'dette_id' => Dette::factory(), // Créer une dette associée
            'montant' => $this->faker->randomFloat(2, 10, 5000), // Montant du paiement entre 10 et 5000
            'status' => $this->faker->randomElement(['en_attente', 'complet', 'partiel']), // Statut aléatoire
        ];
    }
}
