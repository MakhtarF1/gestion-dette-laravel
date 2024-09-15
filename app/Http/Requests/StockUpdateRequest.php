<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Modifier selon les besoins d'autorisation
    }

    public function rules()
    {
        return [
            'articles' => 'required|array',
            'articles.*.id' => 'required|integer|exists:articles,id',
            'articles.*.qteStock' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'articles.required' => 'Les articles sont obligatoires.',
            'articles.*.id.required' => 'L\'ID de l\'article est obligatoire.',
            'articles.*.id.exists' => 'L\'article spécifié n\'existe pas.',
            'articles.*.qteStock.required' => 'La quantité en stock est obligatoire.',
            'articles.*.qteStock.numeric' => 'La quantité en stock doit être un nombre.',
        ];
    }
}
