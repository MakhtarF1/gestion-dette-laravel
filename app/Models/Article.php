<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'prix', 'quantitestock'];

    protected $hidden = ['created_at', 'updated_at'];



    public function scopeDisponible($query, $disponible)
    {
        if ($disponible === 'oui') {
            return $query->where('quantitestock', '>', 0);
        } elseif ($disponible === 'non') {
            return $query->where('quantitestock', '=', 0);
        }

        return $query;
    }
    // Relation avec le modèle Dette

    public function dettes()
    {
        return $this->belongsToMany(Dette::class, 'dette_article')
            ->withPivot('quantite', 'prix')
            ->withTimestamps();
    }
}
