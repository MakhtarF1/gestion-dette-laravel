<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Indique les attributs qui peuvent être remplis
    protected $fillable = ['libelle'];
    
    protected $hidden=['created_at','updated_at'];



    // Si tu veux définir une relation avec les utilisateurs
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
