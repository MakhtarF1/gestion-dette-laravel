<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'telephone',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dettes()
    {
        return $this->hasMany(Dette::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
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
