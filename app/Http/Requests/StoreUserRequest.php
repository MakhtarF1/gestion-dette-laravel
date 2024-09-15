<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autorise toutes les requêtes pour ce cas
    }

    public function rules(): array
    {
        return [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id', // Assurez-vous que le rôle existe
            'login' => 'required|string|unique:users,login|max:255', // Identifiant unique
            'password' => 'required|string|min:8|confirmed', // Mot de passe requis
            'photo' => 'required|string', // Photo (facultatif)
            'qr_code' => 'nullable|string|max:255', // QR Code (facultatif)
        ];
    }

    public function messages(): array
    {
        return [
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'nom.required' => 'Le nom de famille est obligatoire.',
            'nom.string' => 'Le nom de famille doit être une chaîne de caractères.',
            'nom.max' => 'Le nom de famille ne peut pas dépasser 255 caractères.',
            'role_id.required' => 'L\'ID du rôle est obligatoire.',
            'role_id.exists' => 'Le rôle sélectionné doit exister.',
            'login.required' => 'Le login est obligatoire.',
            'login.string' => 'Le login doit être une chaîne de caractères.',
            'login.unique' => 'Le login doit être unique.',
            'login.max' => 'Le login ne peut pas dépasser 255 caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'photo.max' => 'La photo ne peut pas dépasser 255 caractères.',
            'qr_code.max' => 'Le QR Code ne peut pas dépasser 255 caractères.',
        ];
    }
}
