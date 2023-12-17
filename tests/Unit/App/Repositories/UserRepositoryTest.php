<?php

namespace App\Repositories;

use App\Models\User;
use Mockery as m;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testShouldCreateAnUser(): void
    {
        // Set
        $attributes = [
            'name' => 'joao',
            'email' => 'joao@gmail.com',
            'password' => 123123123,
            'phone' => 988888888,
            'rule' => 1,
            'scopes' => 12
        ];

        $user = m::mock(User::class);
        $userRepository = new UserRepository($user);

        // Expectations
        $user->expects()
            ->create($attributes)
            ->andReturn($user);

        // Actions

        $action = $userRepository->createUser($attributes);

        // Assertions
        $this->assertSame($user, $action);
        $this->assertInstanceOf(User::class, $user);
    }
}
