<?php
namespace App\Services;

class ValidateSenegalPhone
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ValidateSenegalPhone();
        }

        return self::$instance;
    }

    public function validate($attribute, $value)
    {
        return preg_match('/^(77|78|70|76|33)\d{7}$/', $value);
    }
}
