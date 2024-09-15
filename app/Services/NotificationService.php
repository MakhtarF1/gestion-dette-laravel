<?php

namespace App\Services;

use App\Repositories\NotificationRepository;

class NotificationService
{
    protected $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getAllNotifications()
    {
        return $this->notificationRepository->getAll();
    }

    public function getNotificationsForClient($clientId)
    {
        return $this->notificationRepository->findByClient($clientId);
    }
}
