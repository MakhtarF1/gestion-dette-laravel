<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Enums\UserRole;

class ValidateUserData
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ValidateUserData();
        }

        return self::$instance;
    }

    public function validate($data, $userId = null)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'login' => 'required|email|unique:users,login,' . ($userId ?? 'NULL'),
            'password' => ['sometimes', function($attribute, $value, $fail) {
                if ($value && !ValidateCustomPassword::getInstance()->validate($attribute, $value)) {
                    $fail('Le ' . $attribute . ' doit comporter au moins 8 caractères et inclure au moins une majuscule, une minuscule, un chiffre et un caractère spécial.');
                }
            }],
            'role' => ['required', function($attribute, $value, $fail) {
                if (!in_array($value, UserRole::values())) {
                    $fail('Le ' . $attribute . ' doit être une des valeurs suivantes : ' . implode(', ', UserRole::values()));
                }
            }],
        ]);

        return $validator->fails() ? $validator->errors() : null;
    }
}
