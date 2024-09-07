<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'surname' => 'required|string|max:255',
            'login' => 'required|string|unique:users,login|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'photo' => 'nullable|string|max:255',
            'nom' => 'required|string|max:255', // Ajout de la règle pour 'nom'
            'prenom' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'surname.required' => 'Le nom est requis.',
            'prenom.required' => 'Le prénom est requis.',
            'login.required' => 'Le login est requis.',
            'login.email' => 'Le login doit être une adresse email valide.',
            'login.unique' => 'Le login doit être unique.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role.required' => 'Le rôle est requis.',
            'role.exists' => 'Le rôle spécifié n\'existe pas.',
            'address.required' => 'L\'adresse est requise.',
            'telephone.required' => 'Le numéro de téléphone est requis.',
            'nom.required' => 'Le champ nom est requis.', // Ajout du message pour 'nom'
        ];
    }
}
