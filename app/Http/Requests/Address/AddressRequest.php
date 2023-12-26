<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->method() == 'GET') {
            return [] ;
        }

        return [
            'zipCode' => ['required', 'string'],
            'city' => ['required', 'string'],
            'street' => ['required', 'string'],
            'neighborhood' => ['required', 'string'],
            'number' => ['required', 'string', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'zipCode.required' => 'O campo CEP é obrigatório.',
            'city.required' => 'O campo Cidade é obrigatório.',
            'street.required' => 'O campo Rua é obrigatório.',
            'neighborhood.required' => 'O campo Bairro é obrigatório.',
            'number.required' => 'O campo Número é obrigatório.',
            'number.numeric' => 'O campo Número deve ser um valor numérico.',
        ];
    }
}
