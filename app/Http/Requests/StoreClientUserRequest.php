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
            'surname' => 'nullable|string|max:255',
            'login' => 'required|string|email|unique:users,login|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
        ];
    }
    
    public function messages()
    {
        return [
            'surname.string' => 'Le nom doit être une chaîne de caractères.',
            'surname.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'login.required' => 'Le login est requis.',
            'login.email' => 'Le login doit être une adresse email valide.',
            'login.unique' => 'Le login doit être unique.',
            'login.max' => 'Le login ne peut pas dépasser 255 caractères.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.required' => 'Le rôle est requis.',
            'role.string' => 'Le rôle doit être une chaîne de caractères.',
            'photo.image' => 'La photo doit être une image.',
            'photo.max' => 'La photo ne peut pas dépasser 2 Mo.',
            'nom.required' => 'Le nom est requis.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 15 caractères.',
        ];
    }
}
