<?php

namespace App\Http\Apis\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function rules()
    {
        return [
          'email' => 'required|email|',
          'password' => 'required|confirmed',
        ];
    }
}
