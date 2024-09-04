<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Attributs qui peuvent être assignés en masse
    protected $fillable = ['surnom', 'prenom', 'adresse', 'telephone', 'user_id'];

    // Attributs à cacher lors de la sérialisation
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dette()
    {
        return $this->hasMany(Dette::class);
    }

    // Scope pour filtrer par comptes associés
    public function scopeWithUser($query)
    {
        return $query->whereHas('user');
    }

    public function scopeWithoutUser($query)
    {
        return $query->doesntHave('user');
    }

   
    public function scopeIsActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('etat', 'actif');
        });
    }

    public function scopeIsInactive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('etat', 'inactif');
        });
    }

 
    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
