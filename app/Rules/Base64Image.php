<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Image implements Rule
{
    public function passes($attribute, $value)
    {
        // Regex to check if the base64 string is a valid image format
        return preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $value);
    }

    public function message()
    {
        return 'La photo doit être une image en base64 valide.';
    }
}
