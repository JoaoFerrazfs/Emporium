<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->method() == 'GET')
        {
            return [] ;
        }

        return [
            'name' => ['required', 'string','unique:products,name,' . $this->id ],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'stock' => ['required', 'numeric'],
            'validate' => ['required', 'date', 'after_or_equal:today'],
            'price' => ['required', 'numeric'],
            'image' => ['mimes:jpg,bmp,png'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser uma string.',
            'name.unique' => 'O nome já está em uso.',

            'description.required' => 'O campo Descrição é obrigatório.',
            'description.string' => 'O campo Descrição deve ser uma string.',

            'ingredients.required' => 'O campo Ingredientes é obrigatório.',
            'ingredients.string' => 'O campo Ingredientes deve ser uma string.',

            'stock.required' => 'O campo Estoque é obrigatório.',
            'stock.numeric' => 'O campo Estoque deve ser um valor numérico.',

            'validate.required' => 'O campo Validade é obrigatório.',
            'validate.date' => 'O campo Validade deve ser uma data válida.',
            'validate.after_or_equal' => 'O campo de Validade deve ser maior ou igual a hoje.',


            'price.required' => 'O campo Preço é obrigatório.',
            'price.numeric' => 'O campo Preço deve ser um valor numérico.',

            'image.mimes' => 'A imagem deve estar em formato JPG, BMP ou PNG.',
        ];
    }
}
