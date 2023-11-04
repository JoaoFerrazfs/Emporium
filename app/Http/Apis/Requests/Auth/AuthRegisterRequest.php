<?php

namespace App\Http\Apis\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
  public function rules()
  {
      return [
          'name' => 'required|max:255',
          'email' => 'required|email|unique:users',
          'password' => 'required|confirmed',
          'rule' => 'boolean',
      ];
  }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->replace(
            array_merge($this->all(),[
            'password' => bcrypt($this->password),
            'password_confirmation' => bcrypt($this->password_confirmation),
            ])
        );
    }
}
