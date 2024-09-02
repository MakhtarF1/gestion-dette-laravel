<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'libelle' => 'required|string|max:255|unique:articles,libelle',
            'prix' => 'required|numeric|min:1',
            'quantitestock' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 255 caractères.',
            'libelle.unique' => 'Le libellé existe déjà.',  
            'prix.required' => 'Le prix est obligatoire.',
            'prix.numeric' => 'Le prix doit être un nombre.',
            'prix.min' => 'Le prix doit être au moins 1.',
            'quantitestock.required' => 'La quantité en stock est obligatoire.',
            'quantitestock.integer' => 'La quantité en stock doit être un entier.',
            'quantitestock.min' => 'La quantité en stock doit être positive.',
        ];
    }
}
