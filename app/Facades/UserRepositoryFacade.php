<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\UserRepositoryInterface; // Assurez-vous que c'est l'interface

class UserRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserRepositoryInterface::class; // Retournez l'interface
    }
}
