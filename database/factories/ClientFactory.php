<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'surname' => $this->faker->lastName,
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->unique()->phoneNumber,
            'user_id' => null, // ou un ID d'utilisateur valide
            'categorie_id' => $this->faker->randomElement([1, 2, 3]), // Gold, Silver, Bronze
            'max_montant' => $this->faker->randomElement([null, 1000.00, 2000.00]), // Nullable pour Bronze
        ];
    }
}
