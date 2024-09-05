<?php

namespace App\Exceptions;

use Exception;

class UserCreationException extends Exception
{
    protected $message = 'Erreur lors de la création de l\'utilisateur.';
    protected $code = 500;
}
