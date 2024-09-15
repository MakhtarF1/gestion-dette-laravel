<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\PaiementServiceInterface; // Assurez-vous que c'est l'interface


class PaiementServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaiementServiceInterface::class;  
    }
}
