<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crée les rôles spécifiques
        Role::create(['libelle' => 'admin']);
        Role::create(['libelle' => 'client']);
        Role::create(['libelle' => 'boutiquier']);
    }
}
