<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:5',
                'max:255'
            ],
            'client_id' => [
                'required',
                'exists:clients,id'
            ],
            'install_type_id' => [
                'required',
                'exists:installation_types,id'
            ],
            'region' => [
                'required',
                'max:2'
            ],
            'equipment' => [
                'required',
                'array',
                'min:1'
            ],
            'equipment.*.id' => [
                'required',
                'integer', 
                'exists:equipment,id'
            ],
            'equipment.*.amount' => [
                'required',
                'integer', // Certifique-se de que é um número inteiro
                'min:1' // Verifique se a quantidade é pelo menos 1
            ]

        ];
    }
}
