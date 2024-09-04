<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientUserRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true; // Autorise toutes les requêtes pour ce cas
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */


     public function rules()
     {
         return [
             'name' => 'required|string|max:255',
             'login' => 'required|string|max:255|unique:users',
             'password' => 'required|string|min:8',
             'role' => 'required|string|exists:roles,libelle',
             'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Ensure file is optional and valid
         ];
     }
     

    /**
     * Obtenez les messages de validation personnalisés.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'surnom.required' => 'Le surnom est obligatoire.',
            'surnom.string' => 'Le surnom doit être une chaîne de caractères.',
            'surnom.max' => 'Le surnom ne peut pas dépasser 255 caractères.',
            'surnom.unique' => 'Le surnom doit être unique.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'telephone.unique' => 'Le numéro de téléphone doit être unique.',
            'user_id.exists' => 'L\'ID utilisateur doit exister dans la table des utilisateurs.',
        ];
    }
}
