<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidateCustomPassword
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ValidateCustomPassword();
        }

        return self::$instance;
    }

    public function validate($attribute, $value)
    {
        $rules = [
            'required',
            'string',
            'min:8',
            'regex:/[A-Z]/',        
            'regex:/[a-z]/',        
            'regex:/\d/',           
            'regex:/[@$!%*?&]/'     
        ];

        $validator = Validator::make([$attribute => $value], [$attribute => implode('|', $rules)]);

        return !$validator->fails();
    }
}
