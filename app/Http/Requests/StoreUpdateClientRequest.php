<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateClientRequest extends FormRequest
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
                'min:2',
                'max:255'
            ],
            'email' => [
                'required',
                'min:5',
                'max:255',
                'email',
            ],
            'phone' => [
                'required',
                'min:8',
                'max:15',
            ],
            'document' => [
                'required',
                'min:11',
                'max:14',
                'unique:clients,document,except,id'
            ],

        ];
    }
}
