<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle', // Assurez-vous d'avoir une colonne 'name' dans votre table 'categories'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class, 'categorie_id'); // Relation avec Client
    }
}
