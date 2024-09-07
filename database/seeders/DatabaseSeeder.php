<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dette;
use Database\Seeders\PaiementSeeder; // Correction ici

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,
             ClientSeeder::class,
            // DetteSeeder::class,
            // ArticleSeeder::class,
            // DetteArticleSeeder::class,
            // PaiementSeeder::class, // Assurez-vous que c'est bien importé
            // DettePaiementSeeder::class, // Ajoutez ceci si nécessaire
        ]);
    }
}
