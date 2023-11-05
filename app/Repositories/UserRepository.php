<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(
        private readonly User $user
    ){
    }

    public function createUser(array $userData): ?User
    {
       return  $this->user->create($userData);
    }
}
