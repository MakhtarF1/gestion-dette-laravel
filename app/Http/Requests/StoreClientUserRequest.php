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
            'photo' => 'nullable|image|max:2048', // Accepte les fichiers image avec une taille maximale de 2 Mo
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'telephone' => 'required|string|max:9',
        ];
    }
    

    public function messages()
    {
        return [
            'surname.required' => 'Le nom est requis.',
            'surname.string' => 'Le nom doit être une chaîne de caractères.',
            'surname.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'login.required' => 'Le login est requis.',
            'login.email' => 'Le login doit être une adresse email valide.',
            'login.unique' => 'Le login doit être unique.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.required' => 'Le rôle est requis.',
            'role.string' => 'Le rôle doit être une chaîne de caractères.',
            'address.required' => 'L\'adresse est requise.',
            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'telephone.required' => 'Le numéro de téléphone est requis.',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 9 caractères.',
        ];
    }
    
}
