<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\UserServiceInterface; // Assurez-vous que c'est l'interface


class UserServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserServiceInterface::class;  // Utilisez l'interface
    }
}
