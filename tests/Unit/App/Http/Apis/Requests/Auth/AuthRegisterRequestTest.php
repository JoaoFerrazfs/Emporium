<?php

namespace Test\App\Http\Apis\Requests\Auth;

use App\Http\Apis\Requests\Auth\AuthRegisterRequest;
use Tests\TestCase;

class AuthRegisterRequestTest extends TestCase
{
    public function testShouldReturnRules(): void
    {
        // Set
        $expected = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'rule' => 'boolean',
            'scopes' => 'array'
        ];

        $authRegisterRequest = new AuthRegisterRequest();

        // Action
        $actual = $authRegisterRequest->rules();


        // Assertions
        $this->assertSame($expected, $actual);

    }
}
