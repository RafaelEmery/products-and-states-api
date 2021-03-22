<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'type' => 'required|in:Cesta Básica, Limpeza, Doces, Carnes, Higiene Pessoal',
            'quantity' => 'required|integer',
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
            'type.in' => 'O produto deve ser dos tipos: Cesta Básica, Limpeza, Doces, Carnes, Higiene Pessoal.',
            'quantity.required' => 'O produto deve possuir a quantidade',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.'
        ];
    }
}
