<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class MongoDette extends Model
{
    use HasFactory; // Ajoutez le trait HasFactory si vous utilisez des factories

    protected $connection = 'mongodb'; // Connexion à MongoDB
    protected $collection; // Définir la collection

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Définir dynamiquement le nom de la collection
        $this->setCollection('dettes_' . date('Y_m_d'));
    }

    // Définir les attributs remplissables
    protected $fillable = [
        'montant',
        'client_id',
        'created_at',
        'updated_at',
        'montant_dette',
        'client', // Correction de 'clients' à 'client'
        'articles',
        'paiements'
    ];

    // Méthode pour définir la collection
    protected function setCollection($name)
    {
        $this->collection = $name;
    }
}
