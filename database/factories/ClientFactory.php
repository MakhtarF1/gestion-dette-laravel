<?php
namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'surnom' => $this->faker->unique()->userName(),
            'prenom' => $this->faker->firstName(),
            'adresse' => $this->faker->address(),
            'telephone' => $this->faker->unique()->regexify('(77|76|75|78|70)[0-9]{7}'), // Numéro sénégalais unique
            'user_id' => null, // Par défaut, pas de compte utilisateur associé
        ];
    }

    public function withUser(User $user): self
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }
}
