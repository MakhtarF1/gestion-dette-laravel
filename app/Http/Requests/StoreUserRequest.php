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
            'login' => 'required|string|email|max:255|unique:users,login',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,libelle',
            'photo' => 'nullable|url', // Validate as URL
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'login.required' => 'Le login est requis.',
            'login.unique' => 'Le login doit être unique.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role.required' => 'Le rôle est requis.',
            'role.exists' => 'Le rôle spécifié n\'existe pas.',
            'photo.url' => 'La photo doit être une URL valide.',
        ];
    }
}
