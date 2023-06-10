<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Product;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'joaoferrazp@gmail.com',
            'rule' => 1,
        ]);

        User::factory()->create([
            'name' => 'Cliente',
            'email' => 'jpferrazsoares@gmail.com',
            'rule' => 0,
        ]);
    }
}
