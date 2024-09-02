<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'etat' => 'actif', // Valeur par défaut
            'role_id' => 1, // Assure-toi que l'ID 1 correspond à un rôle valide
            'login' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('Password123!'), // Mot de passe par défaut
        ];
    }
}
