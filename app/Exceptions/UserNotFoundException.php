<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'Utilisateur non trouvé.';
    protected $code = 404;
}
