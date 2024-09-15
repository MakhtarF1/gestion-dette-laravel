<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\DetteServiceInterface; // Assurez-vous que c'est l'interface


class DetteServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DetteServiceInterface::class;  // Utilisez l'interface
    }
}
