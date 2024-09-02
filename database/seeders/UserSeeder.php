<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Générer 5 utilisateurs
        User::factory()->count(5)->create();
    }
}
