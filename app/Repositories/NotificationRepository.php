<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository
{
    public function getAll()
    {
        return Notification::all();
    }

    public function findByClient($clientId)
    {
        return Notification::where('client_id', $clientId)->get();
    }
}
