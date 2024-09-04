<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\QrServiceInterface; 

class QrServiceFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return QrServiceInterface::class; 
    }
   
}
