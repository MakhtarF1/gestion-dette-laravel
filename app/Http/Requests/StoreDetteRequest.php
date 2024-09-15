<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Assurez-vous que l'utilisateur est autorisé à effectuer cette action.
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'articles' => 'required|array',
            'articles.*.id' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Le client est requis.',
            'client_id.exists' => 'Le client sélectionné est invalide.',
            'articles.required' => 'Les articles sont requis.',
            'articles.*.id.required' => 'L\'article est requis.',
            'articles.*.id.exists' => 'L\'article sélectionné est invalide.',
            'articles.*.quantite.required' => 'La quantité est requise.',
            'articles.*.quantite.min' => 'La quantité doit être au moins de 1.',
        ];
    }
}
