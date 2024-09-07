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
        'surname',
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
        return $this->belongsTo(Role::class);
    }

    // Relation avec le modèle Client
    public function clients()
    {
        return $this->hasOne(Client::class); // Peut avoir plusieurs clients
    }
}
