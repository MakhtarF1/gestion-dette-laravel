<?php
namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // // Crée quelques utilisateurs pour les associer aux clients
        // $users = User::factory()->count(5)->create();

        // // Crée 10 clients, certains avec des utilisateurs associés
        // Client::factory()->count(10)->create()->each(function ($client) use ($users) {
        //     // Associe aléatoirement un utilisateur à certains clients
        //     if ($client->faker->boolean(50)) { // 50% de chance d'associer un utilisateur
        //         $client->user_id = $users->random()->id;
        //         $client->save();
        //     }
        // });
    }
}

