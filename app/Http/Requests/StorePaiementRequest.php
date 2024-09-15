<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaiementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set to true if you want to authorize all users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dette_id' => 'required|exists:dettes,id',
            'montant' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the custom attributes for the validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'dette_id' => 'debt',
            'montant' => 'amount',
        ];
    }

    /**
     * Get custom error messages for the validator.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'dette_id.required' => 'The debt ID field is required.',
            'dette_id.exists' => 'The selected debt ID is invalid.',
            'montant.required' => 'The amount field is required.',
            'montant.numeric' => 'The amount must be a number.',
            'montant.min' => 'The amount must be at least 0.',
        ];
    }
}
