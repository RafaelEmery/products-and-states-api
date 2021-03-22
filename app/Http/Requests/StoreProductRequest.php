<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:180',
            'type' => 'required|in:Cesta Básica, Limpeza, Doces, Carnes, Higiene Pessoal'
        ];
    }

    /**
     * Define the messages for validation rules
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O produto deve possuir nome.',
            'name.max' => 'O nome do produto é grande demais.',
            'type.required' => 'O produto deve possuir um tipo',
            'type.in' => 'O produto deve ser dos tipos: Cesta Básica, Limpeza, Doces, Carnes, Higiene Pessoal.'
        ];
    }
}
