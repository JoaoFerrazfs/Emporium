<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(
        private readonly User $user
    ) {
    }

    public function createUser(array $userData): ?User
    {
        $userData = array_merge($userData, [
            'scopes' => json_encode($userData['scopes'])
        ]);
        return  $this->user->create($userData);
    }
}
