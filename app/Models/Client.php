<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'adresse',
        'telephone',
        'user_id',
        'categorie_id',
        'max_montant',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation entre Client et User
     * Chaque client appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Relation entre Client et Dette
     * Un client peut avoir plusieurs dettes.
     */
    public function dettes()
    {
        return $this->hasMany(Dette::class);
    }

    /**
     * Relation entre Client et Paiement
     * Un client peut avoir plusieurs paiements.
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Relation entre Client et Category
     * Un client appartient à une catégorie.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    /**
     * Scope pour filtrer les clients ayant un utilisateur associé.
     */
    public function scopeWithUser($query)
    {
        return $query->whereHas('user');
    }

    /**
     * Scope pour filtrer les clients n'ayant pas d'utilisateur associé.
     */
    public function scopeWithoutUser($query)
    {
        return $query->doesntHave('user');
    }

    /**
     * Scope pour filtrer les clients ayant un compte utilisateur actif.
     */
    public function scopeIsActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('etat', 'actif');
        });
    }

    /**
     * Scope pour filtrer les clients ayant un compte utilisateur inactif.
     */
    public function scopeIsInactive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('etat', 'inactif');
        });
    }

    /**
     * Scope pour filtrer les clients par leur user_id.
     */
    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }


    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function routeNotificationForSms()
    {
        return $this->user->telephone; // Assurez-vous que le modèle `User` a un champ `phone`
    }

    // Définir comment récupérer l'email pour les notifications mail (optionnel)
    public function routeNotificationForMail()
    {
        return $this->user->login; // Si vous envoyez des mails aux clients
    }
}
