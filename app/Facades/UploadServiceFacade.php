<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\ClientServiceInterface; 

class ClientServiceFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return ClientServiceInterface::class; 
    }
   
}
