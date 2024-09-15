<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Dette;
use Illuminate\Auth\Access\HandlesAuthorization;

class DettePolicy
{
    use HandlesAuthorization;

    public function view(User $authUser, Dette $dette)
    {
        // Admin et boutiquier peuvent voir les dettes
        return in_array(trim($authUser->role->libelle), ['admin', 'boutiquier']);
    }

    public function create(User $authUser)
    {
        // Admin et boutiquier peuvent créer des dettes
        return in_array(trim($authUser->role->libelle), ['admin', 'boutiquier']);
    }

    // Ajoutez d'autres méthodes pour update, delete si nécessaire
}
