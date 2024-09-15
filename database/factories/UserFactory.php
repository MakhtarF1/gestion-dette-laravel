<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->firstName(), // Utilisation de name comme surname
            'prenom' => $this->faker->lastName(),
            'etat' => $this->faker->randomElement(['actif', 'inactif']),
            'role_id' => $this->faker->randomElement([1, 2, 3]), // Choisir aléatoirement 1, 2 ou 3
            'login' => $this->faker->unique()->userName(),
            'password' => bcrypt('Password123!'), // Mot de passe constant
            'photo' => $this->faker->imageUrl(), // URL d'une image aléatoire
            'qr_code' => $this->faker->optional()->imageUrl(), // QR code optionnel
            'etat_photo' => $this->faker->randomElement(['actif', 'inactif']),
        ];
    }
}
