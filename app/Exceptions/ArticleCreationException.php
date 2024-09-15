<?php

namespace App\Exceptions;

use Exception;

class ArticleCreationException extends Exception
{
    public function __construct($message = "Échec de la création de l'article", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
