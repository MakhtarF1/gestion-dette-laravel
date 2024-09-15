<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\PaiementRepositoryInterface; // Assurez-vous que c'est l'interface

class PaiementRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaiementRepositoryInterface::class; // Retournez l'interface
    }
}
