<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    // Les colonnes que l'on peut remplir lors de la création ou de la mise à jour
    protected $fillable = [
        'client_id',
        'statut', // en_attente, approuve, refuse
    ];

    // Relation avec le modèle Client (chaque demande appartient à un client)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relation avec le modèle Article via la table pivot demande_article
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'demande_article')
                    ->withPivot('quantite', 'prix')
                    ->withTimestamps();
    }

    // Scope pour filtrer les demandes par statut
    public function scopeAnnule($query)
    {
        return $query->where('statut', 'annule');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }
}
