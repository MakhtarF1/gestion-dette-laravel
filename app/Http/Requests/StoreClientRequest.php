<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autorise toutes les requêtes pour ce cas
    }

    public function rules()
    {
        return [
            'surname' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'adresse' => 'nullable|string|max:255',
            'categorie_id' => 'required|integer|exists:categories,id', 
            'max_montant' => 'required|numeric',
        ];
    }
    
    
    public function messages(): array
    {
        return [
            'surname.required' => 'Le nom de famille est obligatoire.',
            'surname.string' => 'Le nom de famille doit être une chaîne de caractères.',
            'surname.max' => 'Le nom de famille ne peut pas dépasser 255 caractères.',
            'surname.unique' => 'Le nom de famille doit être unique.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'telephone.unique' => 'Le numéro de téléphone doit être unique.',
            'user_id.exists' => 'L\'ID utilisateur doit exister dans la table des utilisateurs.',
            'categorie.required' => 'La catégorie est obligatoire.', // Correction ici
            'categorie.exists' => 'La catégorie doit exister.', // Correction ici
            'max_montant.required' => 'Le montant maximum est obligatoire.',
            'max_montant.numeric' => 'Le montant maximum doit être un nombre.',
            'max_montant.min' => 'Le montant maximum doit être supérieur ou égal à 0.',
        ];
    }
}
