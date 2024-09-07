<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Crée 10 clients
        $clients = Client::factory()->count(10)->create();

        // Récupérer tous les utilisateurs
        $users = User::all();

        // Associe aléatoirement un utilisateur à certains clients
        $clients->each(function ($client) use ($users) {
            // Utiliser faker directement
            if (fake()->boolean(50)) { // 50% de chance d'associer un utilisateur
                $client->user_id = $users->random()->id;
                $client->save();
            }
        });
    }
}
