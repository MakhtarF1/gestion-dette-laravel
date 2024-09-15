<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemandeRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     */
    public function authorize()
    {
        return true; // Ajustez selon vos besoins d'autorisation
    }

    /**
     * Règles de validation pour les données de la demande.
     */
    public function rules()
    {
        return [
            'statut' => 'nullable|in:en_attente,approuve,refuse',
            'articles' => 'required|array',
            'articles.*.article_id' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min:1',
            'articles.*.prix' => 'nullable|numeric',
        ];
    }

    /**
     * Messages d'erreur personnalisés pour la validation.
     */
    public function messages()
    {
        return [
            'statut.in' => 'Le statut doit être l\'un des suivants : en_attente, approuve, refuse.',
            'articles.required' => 'Au moins un article est requis.',
            'articles.array' => 'Les articles doivent être fournis sous forme de tableau.',
            'articles.*.article_id.required' => 'L\'ID de l\'article est requis.',
            'articles.*.article_id.exists' => 'L\'article sélectionné n\'existe pas.',
            'articles.*.quantite.required' => 'La quantité est requise pour chaque article.',
            'articles.*.quantite.integer' => 'La quantité doit être un nombre entier.',
            'articles.*.quantite.min' => 'La quantité doit être d\'au moins 1.',
            'articles.*.prix.numeric' => 'Le prix doit être un nombre valide.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur.
     */
    public function attributes()
    {
        return [
            'articles.*.article_id' => 'article',
            'articles.*.quantite' => 'quantité',
            'articles.*.prix' => 'prix',
        ];
    }
}
