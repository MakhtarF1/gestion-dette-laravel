<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\DetteRepositoryInterface; // Assurez-vous que c'est l'interface

class DetteRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DetteRepositoryInterface::class; // Retournez l'interface
    }
}
