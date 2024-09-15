<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'prenom',
        'nom',
        'role_id', // ID du rôle
        'login', // Utilisé comme identifiant
        'password',
        'photo',
        'qr_code'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'password', // Il est conseillé de cacher le mot de passe
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relation avec le modèle Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // Assurez-vous que la colonne `role_id` existe dans la table users
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'user_id'); 
    }

    public function routeNotificationForMail($notification)
    {
        return $this->login; // Utiliser le champ login comme adresse e-mail
    }

    // Ajouter la méthode isBoutiquier
    public function isBoutiquier(): bool
    {
        // Assurez-vous que 'boutiquier' est bien le libellé du rôle correspondant
        return $this->role && $this->role->libelle === 'boutiquier'; 
    }
}
