<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Dette; // Modèle pour la table des dettes
use App\Models\Paiement; // Modèle pour la table des paiements

class DettePaiementSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create(); // Initialisation de Faker
    }

    public function run()
    {
        // Récupérez tous les ID des dettes et paiements existants
        $dettesIds = Dette::pluck('id')->toArray();
        $paiementsIds = Paiement::pluck('id')->toArray();
    
        // Vérifiez si les tableaux sont vides
        if (empty($dettesIds) || empty($paiementsIds)) {
            throw new \Exception("Aucun ID de dette ou de paiement trouvé. Assurez-vous d'avoir des enregistrements dans les tables correspondantes.");
        }
    
        // Créez des enregistrements pour la table pivot
        $dettePaiementData = [];
    
        for ($i = 0; $i < 30; $i++) {
            $dettePaiementData[] = [
                'dette_id' => $this->faker->randomElement($dettesIds),
                'paiement_id' => $this->faker->randomElement($paiementsIds),
                'montant' => $this->faker->randomFloat(2, 10, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        // Insérez les enregistrements dans la table pivot
        DB::table('dette_paiement')->insert($dettePaiementData);
    }
    
}
