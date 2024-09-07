<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Listeners\UserCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreated::class => [
            UserCreatedListener::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
