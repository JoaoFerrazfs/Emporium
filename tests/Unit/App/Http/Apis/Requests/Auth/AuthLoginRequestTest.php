<?php

namespace Test\App\Http\Apis\Requests\Auth;

use App\Http\Apis\Requests\Auth\AuthLoginRequest;
use Tests\TestCase;

class AuthLoginRequestTest extends TestCase
{
    public function testShouldReturnRules(): void
    {
        // Set
        $expected = [
            'email' => 'required|email|',
            'password' => 'required|confirmed',
        ];
        $authLoginRequest = new AuthLoginRequest();

        // Action
        $actual = $authLoginRequest->rules();


        // Assertions
        $this->assertSame($expected, $actual);

    }

}
