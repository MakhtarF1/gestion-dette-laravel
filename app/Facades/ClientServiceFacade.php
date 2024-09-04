<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\ClientServiceInterface; // Assurez-vous que c'est l'interface


class ClientServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ClientServiceInterface::class;  // Utilisez l'interface
    }
}
