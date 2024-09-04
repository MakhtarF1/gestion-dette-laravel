<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\ClientRepositoryInterface; // Assurez-vous que c'est l'interface

class ClientRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ClientRepositoryInterface::class; // Retournez l'interface
    }
}
