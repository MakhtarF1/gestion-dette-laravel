<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
                // Vérifier s'il y a des utilisateurs disponibles
                if ($users->isNotEmpty()) {
                    $client->user_id = $users->random()->id;
                    $client->save();
                }
            }
        });
    }
}
