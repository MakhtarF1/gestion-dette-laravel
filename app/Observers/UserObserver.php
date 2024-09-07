<?php

namespace App\Observers;
use App\Events\UserCreated;
use App\Models\User;


class UserObserver
{
    public function created(User $user): void
    {
        event(new UserCreated($user));
    }

    public function creating(User $user)
    {
        // Logique avant la création
    }

    public function updating(User $user)
    {
        // Logique avant la mise à jour
    }

    public function deleting(User $user)
    {
        // Logique avant la suppression
    }
}

