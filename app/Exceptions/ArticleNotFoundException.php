<?php

namespace App\Exceptions;

use Exception;

class ArticleNotFoundException extends Exception
{
    public function __construct($message = "Article non trouvé", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
