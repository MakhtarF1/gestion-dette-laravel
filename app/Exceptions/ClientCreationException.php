<?php

namespace App\Exceptions;

use Exception;

class ClientCreationException extends Exception
{
    public function __construct($message = "Échec de la création du client", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
