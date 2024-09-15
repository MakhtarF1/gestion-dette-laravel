<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function view(User $authUser, Client $client)
    {
        // Admin et boutiquier peuvent voir les clients
        return in_array(trim($authUser->role->libelle), ['admin', 'boutiquier']);
    }

    public function create(User $authUser)
    {
        // Seul l'admin peut créer des clients
        return $authUser->role->libelle === 'admin';
    }

    // Ajoutez d'autres méthodes pour update, delete si nécessaire
}
