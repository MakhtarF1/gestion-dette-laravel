<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'login' => 'required|string|unique:users,login,' . $this->route('user'),
            'password' => 'required|string|min:5|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_+{}\[\]:;"\'<>?,.]/',
            'role' => 'required|string|exists:roles,libelle', // Validation pour le rôle
        ];
    }
    

    public function messages()
    {
        return [
            'name.required' => 'Le nom est requis.', // Message pour le nom
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'login.required' => 'Le login est requis.', // Message pour le login
            'login.unique' => 'Le login doit être unique.',
            'password.required' => 'Le mot de passe est requis.', // Message pour le mot de passe
            'password.min' => 'Le mot de passe doit contenir au moins 5 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
            'role.required' => 'Le rôle est requis.', // Message pour le rôle
            'role.exists' => 'Le rôle sélectionné n\'est pas valide.',
        ];
    }
}
