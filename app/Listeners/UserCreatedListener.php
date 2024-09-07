<?php
namespace App\Listeners;

use App\Events\UserCreated;
use App\Jobs\GenerateUserQrCode;
use App\Jobs\SendUserEmail;

class UserCreatedListener
{
    public function handle(UserCreated $event)
    {
        GenerateUserQrCode::dispatch($event->user->id);
        SendUserEmail::dispatch($event->user->id);
    }
}
