<?php

namespace App\Http\Apis\Requests\v1\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'term' => 'required|min:3'
        ];
    }
}
