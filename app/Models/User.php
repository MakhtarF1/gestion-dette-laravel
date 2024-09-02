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
        'name',
        'role_id', // Change 'role' to 'role_id'
        'login', // Corrected from 'email' to 'login'
        'password',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relation avec le modèle Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // Assurez-vous que 'role_id' est le bon champ
    }

    // Relation avec le modèle Client
    public function clients()
    {
        return $this->hasOne(Client::class);
    }
}
